<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        $totalAnggota = \App\Models\User::where('role', 'user')->count();
        $totalSimpanan = \App\Models\Simpanan::sum('jumlah');
        $totalPinjamanAktif = \App\Models\LoanApplication::where('status', 'approved')->count(); // Pastikan kolom status ada di LoanApplication
        $totalNominalPinjaman = \App\Models\LoanApplication::where('status', 'approved')->sum('loan_amount');
        $transaksiTerbaru = \App\Models\Transaksi::with('user')->latest()->take(5)->get();

        // Ambil top 3 penabung bulan ini
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        $topPenabung = \App\Models\User::select('id', 'nama')
            ->withSum(['simpanans' => function($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
            }], 'jumlah')
            ->orderByDesc('simpanans_sum_jumlah')
            ->take(3)
            ->get();

        return view('admin_dashboard', compact(
            'totalAnggota',
            'totalSimpanan',
            'totalPinjamanAktif',
            'totalNominalPinjaman',
            'transaksiTerbaru',
            'topPenabung'
        ));
    }
}
