<?php
namespace App\Http\Controllers;

use App\Models\Simpanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class SimpananController extends Controller
{
    public function __construct()
    {
        // Constructor can remain empty
    }

    public function index()
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

    public function create(Request $request)
    {
        $user = Auth::user();
        $type = $request->get('type', 'pokok');

        // Validate simpanan type
        if (!in_array($type, ['pokok', 'wajib', 'sukarela'])) {
            return redirect()->route('dashboard.simpanan')
                ->with('error', 'Jenis simpanan tidak valid.');
        }

        // If type is wajib, check if payment already made this month
        if ($type === 'wajib') {
            $currentMonthWajib = $this->checkCurrentMonthWajib($user->id);

            if ($currentMonthWajib) {
                return redirect()->route('dashboard.simpanan')
                    ->with('info', 'Anda sudah membayar simpanan wajib untuk bulan ini.');
            }
        }

        // Calculate totals
        $totalSimpanan = [
            'all' => Simpanan::where('user_id', $user->id)->sum('jumlah'),
            'pokok' => Simpanan::where('user_id', $user->id)
                        ->where('jenis_simpanan', 'pokok')
                        ->sum('jumlah'),
            'wajib' => Simpanan::where('user_id', $user->id)
                        ->where('jenis_simpanan', 'wajib')
                        ->sum('jumlah'),
            'sukarela' => Simpanan::where('user_id', $user->id)
                        ->where('jenis_simpanan', 'sukarela')
                        ->sum('jumlah')
        ];

        // Pass both the totals array and single total value for backwards compatibility
        return view('dashboard.create-simpanan', [
            'type' => $type,
            'user' => $user,
            'totalSimpanan' => $totalSimpanan['all'],
            'totalSimpananByType' => $totalSimpanan
        ]);
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        // Validate request first
        $request->validate([
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
            'payment_method' => 'required|in:transfer,cash'
        ]);

        // Format jumlah from string to number if needed
        $jumlah = $request->jumlah;
        if (is_string($jumlah)) {
            $jumlah = str_replace('.', '', $jumlah); // Remove thousand separators
            $jumlah = str_replace(',', '.', $jumlah); // Replace comma with dot for decimal
        }

        // Additional validation for minimum amounts
        $minAmount = [
            'pokok' => 100000,  // Rp 100.000
            'wajib' => 50000,   // Rp 50.000
            'sukarela' => 10000 // Rp 10.000
        ];

        if ($jumlah < $minAmount[$request->jenis_simpanan]) {
            return redirect()->back()
                ->withInput()
                ->with('error', "Minimal simpanan {$request->jenis_simpanan} adalah Rp " .
                    number_format($minAmount[$request->jenis_simpanan], 0, ',', '.'));
        }

        // Check wajib payment for current month
        if ($request->jenis_simpanan === 'wajib') {
            if ($this->checkCurrentMonthWajib($user->id)) {
                return redirect()->route('dashboard.simpanan')
                    ->with('info', 'Anda sudah membayar simpanan wajib untuk bulan ini.');
            }
        }

        try {
            DB::beginTransaction();

            $currentMonth = Carbon::now()->format('F Y');

            // Create simpanan record
            $simpanan = Simpanan::create([
                'user_id' => $user->id,
                'jenis_simpanan' => $request->jenis_simpanan,
                'jumlah' => $jumlah,
                'tanggal' => now(),
                'keterangan' => $this->generateKeterangan(
                    $request->jenis_simpanan,
                    $request->payment_method,
                    $currentMonth,
                    $request->keterangan
                ),
                'status' => 'pending'
            ]);

            DB::commit();

            return redirect()->route('dashboard.simpanan')
                ->with('success', 'Simpanan berhasil dibuat dan menunggu verifikasi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }

    private function generateKeterangan($jenisSimpanan, $paymentMethod, $currentMonth, $customKeterangan = null)
    {
        if ($jenisSimpanan === 'wajib') {
            return "Simpanan Wajib $currentMonth via " . ucfirst($paymentMethod);
        }

        return ($customKeterangan ?: "Setoran " . ucfirst($jenisSimpanan)) .
               " via " . ucfirst($paymentMethod);
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
}
