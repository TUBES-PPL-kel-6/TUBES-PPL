<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Simpanan;
use App\Models\LoanApplication;
use App\Models\Notification;
use App\Models\Transaksi;

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

        // Transaksi terbaru (ambil 5 terakhir)
        $recentTransactions = \App\Models\Transaksi::where('user_id', $userId)
            ->orderBy('tanggal', 'desc')
            ->take(5)
            ->get();

        // Notifikasi terbaru (ambil 3 terakhir)
        $recentNotifications = \App\Models\Notification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        // Jumlah notifikasi belum dibaca
        $unreadNotifications = \App\Models\Notification::where('user_id', $userId)
            ->where('is_read', false)
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
}
