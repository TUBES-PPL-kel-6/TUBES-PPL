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
        $totalPinjamanAktif = \App\Models\LoanApplication::where('status', 'approved')->count();
        $totalNominalPinjaman = \App\Models\LoanApplication::where('status', 'approved')->sum('loan_amount');
        $transaksiTerbaru = \App\Models\Transaksi::with('user')->latest()->take(5)->get();

        // Top penabung bulan ini
        $startOfMonth = \Carbon\Carbon::now()->startOfMonth();
        $endOfMonth = \Carbon\Carbon::now()->endOfMonth();
        $topPenabung = \App\Models\User::select('id', 'nama')
            ->withSum(['simpanans' => function($q) use ($startOfMonth, $endOfMonth) {
                $q->whereBetween('tanggal', [$startOfMonth, $endOfMonth]);
            }], 'jumlah')
            ->orderByDesc('simpanans_sum_jumlah')
            ->take(3)
            ->get();

        // Grafik laba bulanan
        $year = now()->year;
        $monthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulanSimpanan = \App\Models\Simpanan::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $m)
                ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
                ->where('status', 'approved')
                ->sum('jumlah');

            $bulanPinjaman = \App\Models\LoanPayment::whereYear('payment_date', $year)
                ->whereMonth('payment_date', $m)
                ->where('status', 'verified')
                ->sum('amount') * 0.01;

            $bulanPengeluaran = \App\Models\LoanApplication::whereYear('application_date', $year)
                ->whereMonth('application_date', $m)
                ->where('status', 'approved')
                ->sum('loan_amount');

            $monthly[] = [
                'bulan' => $m,
                'laba_simpanan' => $bulanSimpanan,
                'laba_pinjaman' => $bulanPinjaman,
                'pengeluaran' => $bulanPengeluaran,
                'total_laba' => ($bulanSimpanan + $bulanPinjaman) - $bulanPengeluaran,
            ];
        }

        return view('admin_dashboard', compact(
            'totalAnggota',
            'totalSimpanan',
            'totalPinjamanAktif',
            'totalNominalPinjaman',
            'transaksiTerbaru',
            'topPenabung',
            'monthly',
            'year'
        ));
    }
}
