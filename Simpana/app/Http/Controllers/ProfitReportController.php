<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\LoanPayment;
use App\Models\LoanApplication;
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

        // Penghasilan
        $labaSimpanan = Simpanan::whereYear('tanggal', $year)
            ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
            ->where('status', 'approved')
            ->sum('jumlah');

        $labaPinjaman = LoanPayment::whereYear('payment_date', $year)
            ->where('status', 'verified')
            ->sum('amount') * 0.01;

        // Pengeluaran: total pinjaman yang dicairkan tahun ini
        $pengeluaranPinjaman = LoanApplication::whereYear('application_date', $year)
            ->where('status', 'approved')
            ->sum('loan_amount');

        // Total laba bersih
        $totalLaba = ($labaSimpanan + $labaPinjaman) - $pengeluaranPinjaman;

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

            $bulanPengeluaran = LoanApplication::whereYear('application_date', $year)
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

        return view('admin.profit-report', [
            'year' => $year,
            'totalLaba' => $totalLaba,
            'labaSimpanan' => $labaSimpanan,
            'labaPinjaman' => $labaPinjaman,
            'pengeluaranPinjaman' => $pengeluaranPinjaman,
            'monthly' => $monthly,
        ]);
    }

    public function adminDashboard()
    {
        $year = now()->year;

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

            $bulanPengeluaran = LoanApplication::whereYear('application_date', $year)
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

        return view('admin_dashboard', compact('monthly', 'year'));
    }
}
