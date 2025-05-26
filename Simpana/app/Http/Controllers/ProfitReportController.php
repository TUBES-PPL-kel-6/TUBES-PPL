<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProfitReportController extends Controller
{
    public function index()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $monthlyProfits = $this->getMonthlyProfits();

        // Calculate total profit this year
        $totalLabaTahunIni = $monthlyProfits
            ->where('tahun', Carbon::now()->year)
            ->sum('total_laba');

        // Calculate growth from last month
        $bulanIni = $monthlyProfits
            ->where('tahun', Carbon::now()->year)
            ->where('bulan', Carbon::now()->month)
            ->first();

        $bulanLalu = $monthlyProfits
            ->where('tahun', Carbon::now()->year)
            ->where('bulan', Carbon::now()->month - 1)
            ->first();

        $pertumbuhanBulanan = $this->hitungPertumbuhan($bulanIni, $bulanLalu);

        return view('admin.profit-report', compact(
            'monthlyProfits',
            'totalLabaTahunIni',
            'pertumbuhanBulanan'
        ));
    }

    private function hitungPertumbuhan($bulanIni, $bulanLalu)
    {
        if (!$bulanIni || !$bulanLalu || $bulanLalu->total_laba <= 0) {
            return 0;
        }

        return (($bulanIni->total_laba - $bulanLalu->total_laba) / $bulanLalu->total_laba) * 100;
    }

    private function getMonthlyProfits()
    {
        return DB::table('transaksis AS t')
            ->leftJoin('simpanans AS s', 't.simpanan_id', '=', 's.id')
            ->select(
                DB::raw('MONTH(t.created_at) as bulan'),
                DB::raw('YEAR(t.created_at) as tahun'),
                // Profit from sukarela savings (0.5%)
                DB::raw('SUM(CASE
                    WHEN t.jenis_transaksi = "setor"
                    AND s.jenis_simpanan = "sukarela"
                    AND t.status = "approved"
                    THEN t.jumlah * 0.005
                    ELSE 0
                END) as laba_simpanan'),
                // Profit from loan payments (1%)
                DB::raw('SUM(CASE
                    WHEN t.jenis_transaksi = "angsuran"
                    AND t.status = "approved"
                    THEN t.jumlah * 0.01
                    ELSE 0
                END) as laba_pinjaman'),
                // Total profit
                DB::raw('SUM(CASE
                    WHEN t.jenis_transaksi = "setor"
                    AND s.jenis_simpanan = "sukarela"
                    AND t.status = "approved"
                    THEN t.jumlah * 0.005
                    WHEN t.jenis_transaksi = "angsuran"
                    AND t.status = "approved"
                    THEN t.jumlah * 0.01
                    ELSE 0
                END) as total_laba')
            )
            ->where('t.status', 'approved')
            ->groupBy('tahun', 'bulan')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->get();
    }

    public function getChartData()
    {
        $yearlyData = $this->getMonthlyProfits()
            ->where('tahun', Carbon::now()->year)
            ->values();

        $months = $yearlyData->pluck('bulan')->map(function($month) {
            return Carbon::create(null, $month)->format('F');
        });

        return response()->json([
            'labels' => $months,
            'datasets' => [
                [
                    'label' => 'Laba Simpanan',
                    'data' => $yearlyData->pluck('laba_simpanan'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.2)',
                    'borderColor' => 'rgba(54, 162, 235, 1)',
                    'borderWidth' => 1
                ],
                [
                    'label' => 'Laba Pinjaman',
                    'data' => $yearlyData->pluck('laba_pinjaman'),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.2)',
                    'borderColor' => 'rgba(255, 99, 132, 1)',
                    'borderWidth' => 1
                ]
            ]
        ]);
    }
}
