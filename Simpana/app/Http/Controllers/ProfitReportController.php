<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\LoanPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfitReportController extends Controller
{
    public function index(Request $request)
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $year = $request->input('year', now()->year);

        // Gabungkan semua jenis simpanan (pokok, wajib, sukarela)
        $labaSimpanan = Simpanan::whereYear('tanggal', $year)
            ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
            ->where('status', 'approved')
            ->sum('jumlah');

        // Laba Pinjaman: 1% dari pembayaran angsuran yang sudah diverifikasi
        $labaPinjaman = LoanPayment::whereYear('payment_date', $year)
            ->where('status', 'verified')
            ->sum('amount') * 0.01;

        // Total laba
        $totalLaba = $labaSimpanan + $labaPinjaman;

        // Data bulanan
        $monthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulanSimpanan = Simpanan::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $m)
                ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
                ->where('status', 'approved')
                ->sum('jumlah');

            $bulanPinjaman = LoanPayment::whereYear('payment_date', $year)
                ->whereMonth('payment_date', $m)
                ->where('status', 'verified')
                ->sum('amount') * 0.01;

            $monthly[] = [
                'bulan' => $m,
                'laba_simpanan' => $bulanSimpanan,
                'laba_pinjaman' => $bulanPinjaman,
                'total_laba' => $bulanSimpanan + $bulanPinjaman,
            ];
        }

        return view('admin.profit-report', [
            'year' => $year,
            'totalLaba' => $totalLaba,
            'labaSimpanan' => $labaSimpanan,
            'labaPinjaman' => $labaPinjaman,
            'monthly' => $monthly,
        ]);
    }
}
