<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\LoanApplication;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProfitReportController extends Controller
{
    protected function getMonthlyProfits()
    {
        return Transaksi::selectRaw('
            MONTH(created_at) as bulan,
            YEAR(created_at) as tahun,
            SUM(CASE WHEN jenis_transaksi = "simpanan" THEN jumlah * 0.005 ELSE 0 END) as laba_simpanan,
            SUM(CASE WHEN jenis_transaksi = "pinjaman" THEN jumlah * 0.01 ELSE 0 END) as laba_pinjaman,
            SUM(CASE
                WHEN jenis_transaksi = "simpanan" THEN jumlah * 0.005
                WHEN jenis_transaksi = "pinjaman" THEN jumlah * 0.01
                ELSE 0
            END) as total_laba'
        )
        ->where('status', 'completed')
        ->groupBy('tahun', 'bulan')
        ->orderBy('tahun', 'desc')
        ->orderBy('bulan', 'desc')
        ->get();
    }

    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $monthlyProfits = $this->getMonthlyProfits();

        // Calculate total profit this year
        $totalLabaTahunIni = $monthlyProfits
            ->where('tahun', date('Y'))
            ->sum('total_laba');

        // Calculate growth from last month
        $bulanIni = $monthlyProfits
            ->where('tahun', date('Y'))
            ->where('bulan', date('m'))
            ->first();

        $bulanLalu = $monthlyProfits
            ->where('tahun', date('Y'))
            ->where('bulan', date('m')-1)
            ->first();

        $pertumbuhanBulanan = 0;
        if($bulanLalu && $bulanIni && $bulanLalu->total_laba > 0) {
            $pertumbuhanBulanan = (($bulanIni->total_laba - $bulanLalu->total_laba) / $bulanLalu->total_laba) * 100;
        }

        return view('admin.profit-report', compact(
            'monthlyProfits',
            'totalLabaTahunIni',
            'pertumbuhanBulanan'
        ));
    }

    public function getChartData()
    {
        $monthlyProfits = $this->getMonthlyProfits();
        $yearlyData = $monthlyProfits
            ->where('tahun', date('Y'))
            ->values();

        return response()->json([
            'labels' => $yearlyData->pluck('bulan')->map(function($month) {
                return date('F', mktime(0, 0, 0, $month, 1));
            }),
            'datasets' => [
                [
                    'label' => 'Laba Simpanan',
                    'data' => $yearlyData->pluck('laba_simpanan'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                ],
                [
                    'label' => 'Laba Pinjaman',
                    'data' => $yearlyData->pluck('laba_pinjaman'),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                ]
            ]
        ]);
    }
}
