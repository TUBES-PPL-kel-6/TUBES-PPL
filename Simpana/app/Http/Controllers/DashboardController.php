<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Total Simpanan Pokok
        $totalSimpananPokok = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'pokok')
            ->where('status', 'approved')
            ->sum('jumlah');

        // Riwayat Simpanan Pokok
        $riwayatPokok = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'pokok')
            ->orderBy('tanggal', 'desc')
            ->get();

        // Hitung total simpanan
        $totalSimpananPokok = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'pokok')
            ->sum('jumlah');

        $totalSimpananWajib = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'wajib')
            ->sum('jumlah');

        $totalSimpananSukarela = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'sukarela')
            ->sum('jumlah');

        // Ambil transaksi terbaru
        $transaksiTerbaru = Transaksi::where('user_id', $user->id)
            ->with('simpanan')
            ->latest()
            ->take(5)
            ->get();

        return view('layouts.dashboard', compact(
            'user',
            'totalSimpananPokok',
            'totalSimpananWajib',
            'totalSimpananSukarela',
            'transaksiTerbaru'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        // Ensure $user is an instance of the Eloquent User model
        if (!($user instanceof \App\Models\User)) {
            $user = \App\Models\User::find($user->id);
        }

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        $user->nama = $request->nama;
        $user->email = $request->email;
        $user->no_telp = $request->no_telp;
        $user->alamat = $request->alamat;
        $user->save();

        return redirect()->route('dashboard.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function transactions()
    {
        $user = Auth::user();
        $transactions = Transaksi::where('user_id', $user->id)
            ->with('simpanan')
            ->latest()
            ->paginate(10);

        return view('dashboard.transactions', compact('user', 'transactions'));
    }

    public function simpanan()
    {
        $user = Auth::user();

        // Get all simpanan records for this user
        $simpanans = Simpanan::where('user_id', $user->id)
                    ->orderBy('tanggal', 'desc')
                    ->get();

        // Calculate total simpanan
        $totalSimpanan = Simpanan::where('user_id', $user->id)
                        ->sum('jumlah');

        // Get the earliest simpanan date
        $tanggalBuka = $simpanans->min('tanggal');

        // Check if user has paid this month's wajib
        $currentMonthWajib = $this->checkCurrentMonthWajib($user->id);

        return view('dashboard.simpanan', compact(
            'user',
            'totalSimpanan',
            'simpanans',
            'tanggalBuka',
            'currentMonthWajib'
        ));
    }

    public function createSimpanan(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'pokok');

        // Validate simpanan type
        if (!in_array($type, ['pokok', 'wajib', 'sukarela'])) {
            return redirect()->route('dashboard.simpanan')
                ->with('error', 'Jenis simpanan tidak valid.');
        }

        // Check if user has paid this month's wajib
        $currentMonthWajib = $this->checkCurrentMonthWajib($user->id);

        // If type is wajib, check if payment already made this month
        if ($type === 'wajib' && $currentMonthWajib) {
            return redirect()->route('dashboard.simpanan')
                ->with('info', 'Anda sudah membayar simpanan wajib untuk bulan ini.');
        }

        // Calculate totals
        $totalSimpanan = Simpanan::where('user_id', $user->id)->sum('jumlah');

        return view('dashboard.create-simpanan', [
            'type' => $type,
            'user' => $user,
            'totalSimpanan' => $totalSimpanan,
            'currentMonthWajib' => $currentMonthWajib
        ]);
    }

    /**
     * Check if user has already paid the wajib simpanan for current month
     */
    private function checkCurrentMonthWajib($userId)
    {
        $now = Carbon::now();

        return Simpanan::where('user_id', $userId)
                ->where('jenis_simpanan', 'wajib')
                ->whereYear('tanggal', $now->year)
                ->whereMonth('tanggal', $now->month)
                ->first();
    }

    public function storeSimpanan(Request $request)
    {
        $request->validate([
            'jenis_simpanan' => 'required|in:wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $jumlah = str_replace('.', '', $request->jumlah);
        $jumlah = str_replace(',', '.', $jumlah);

        $simpanan = Simpanan::create([
            'user_id' => Auth::id(),
            'jenis_simpanan' => $request->jenis_simpanan,
            'jumlah' => $jumlah,
            'tanggal' => now(),
            'keterangan' => $request->keterangan,

            'status' => 'approved', // <-- langsung approved
        ]);

        // Buat notifikasi ke user
        \App\Models\Notification::create([
            'user_id' => Auth::id(),
            'type' => 'simpanan',
            'message' => 'Setoran simpanan ' . ucfirst($request->jenis_simpanan) . ' sebesar Rp' . number_format($request->jumlah, 0, ',', '.') . ' berhasil diajukan.',
            'read_at' => null,
        ]);

        return redirect()->route('dashboard.simpanan')
            ->with('success', 'Setoran simpanan berhasil ditambahkan');
    }

    // Method untuk Teller
    public function approveSimpanan(Request $request, Simpanan $simpanan)
    {
        if (Auth::user()->role !== 'teller') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $simpanan->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->status === 'approved') {
            Transaksi::create([
                'user_id' => $simpanan->user_id,
                'simpanan_id' => $simpanan->id,
                'jenis_transaksi' => 'setor',
                'jumlah' => $simpanan->jumlah,
                'tanggal' => now(),
                'status' => 'approved',
                'keterangan' => 'Setoran simpanan ' . $simpanan->jenis_simpanan,
            ]);
        }

        return redirect()->back()->with('success', 'Status simpanan berhasil diperbarui');
    }

    // Halaman Unduh SHU
    public function shu()
    {
        return view('dashboard.shu');
    }

    // Download SHU as PDF for a specific year
    public function downloadShuPdf($tahun)
    {
        $user = Auth::user();
        $transaksi = \App\Models\Transaksi::where('user_id', $user->id)
            ->whereYear('tanggal', $tahun)
            ->get();
        $shus = \App\Models\Shu::where('user_id', $user->id)
            ->where('tahun', $tahun)
            ->get();
        return \Barryvdh\DomPDF\Facade\Pdf::loadView('dashboard.shu_pdf', [
            'user' => $user,
            'tahun' => $tahun,
            'transaksi' => $transaksi,
            'shus' => $shus,
        ])->download('SHU_' . $user->nama . '_' . $tahun . '.pdf');
    }
}
