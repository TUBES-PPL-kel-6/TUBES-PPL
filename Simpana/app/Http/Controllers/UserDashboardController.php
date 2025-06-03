<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Simpanan;
use App\Models\LoanApplication;
use App\Models\Notification;
use App\Models\Transaksi;
use App\Models\LoanPayment;

class UserDashboardController extends Controller
{
    public function index()
    {
        $userId = Auth::id();

        // Total simpanan
        $totalSimpanan = \App\Models\Simpanan::where('user_id', $userId)->sum('jumlah');

        // Total pinjaman
        $totalPinjaman = \App\Models\LoanApplication::where('user_id', $userId)->sum('loan_amount');

        // SHU (jika ada)
        $shu = 0; // Ganti sesuai logika SHU kamu

        // Sisa angsuran (jumlah pinjaman yang belum lunas)
        $sisaAngsuran = \App\Models\LoanApplication::where('user_id', $userId)
            ->where('status', 'approved')
            ->whereHas('payments', function($q) {
                $q->where('status', 'pending');
            })
            ->count();

        // Ambil riwayat simpanan
        $simpanan = \App\Models\Simpanan::where('user_id', $userId)
            ->orderByDesc('tanggal')
            ->get()
            ->map(function($item) {
                return (object)[
                    'type' => 'simpanan',
                    'description' => 'Simpanan ' . ucfirst($item->jenis_simpanan),
                    'method' => '-',
                    'tanggal' => $item->tanggal,
                    'jumlah' => $item->jumlah,
                    'status' => $item->status,
                ];
            });

        // Ambil riwayat pembayaran pinjaman (angsuran)
        $loanPayments = LoanPayment::whereHas('loanApplication', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->orderByDesc('payment_date')
            ->get()
            ->map(function($item) {
                return (object)[
                    'type' => 'angsuran',
                    'description' => 'Pembayaran Angsuran ke-' . $item->installment_number,
                    'method' => ucfirst($item->payment_method ?? '-'),
                    'tanggal' => $item->payment_date,
                    'jumlah' => $item->amount,
                    'status' => $item->status,
                ];
            });

        // Gabungkan dan urutkan berdasarkan tanggal, ambil 5 terbaru
        $recentTransactions = $simpanan->concat($loanPayments)
            ->sortByDesc('tanggal')
            ->take(5)
            ->values();

        // Notifikasi terbaru (ambil 3 terakhir)
        $recentNotifications = \App\Models\Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Jumlah notifikasi belum dibaca
        $unreadNotifications = \App\Models\Notification::where('user_id', $userId)
            ->whereNull('read_at')
            ->count();

        return view('layouts.dashboard', compact(
            'totalSimpanan',
            'totalPinjaman',
            'shu',
            'sisaAngsuran',
            'recentTransactions',
            'recentNotifications',
            'unreadNotifications'
        ));
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'no_telp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:500'
        ]);

        try {
            $user = Auth::user();
            $user->update([
                'nama' => $request->nama,
                'email' => $request->email,
                'no_telp' => $request->no_telp,
                'alamat' => $request->alamat
            ]);

            return redirect()->route('dashboard.profile')->with('success', 'Profil berhasil diperbarui!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memperbarui profil.')->withInput();
        }
    }
}
