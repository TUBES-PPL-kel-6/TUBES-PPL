<?php

namespace App\Http\Controllers;

use App\Models\Shu;
use App\Models\User;
use App\Models\Simpanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ShuController extends Controller
{
    public function index()
    {
        if (auth()->user()->role !== 'admin') {
            return redirect()->back()->with('error', 'Unauthorized access');
        }

        $shus = Shu::with('user')
            ->orderBy('tahun', 'desc')
            ->get()
            ->groupBy('tahun');

        return view('admin.shu.index', compact('shus'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020|max:' . date('Y')
        ]);

        try {
            DB::beginTransaction();

            // Delete existing SHU for the year if exists
            Shu::where('tahun', $request->tahun)->delete();

            // Get total pemasukan (from simpanan sukarela & pinjaman interest)
            $totalPemasukan = Transaksi::whereYear('created_at', $request->tahun)
                ->where('status', 'completed')
                ->sum(DB::raw('
                    CASE
                        WHEN jenis_transaksi = "simpanan" THEN jumlah * 0.005
                        WHEN jenis_transaksi = "pinjaman" THEN jumlah * 0.01
                        ELSE 0
                    END
                '));

            // Assume operational cost is 30% of total income
            $operationalCost = $totalPemasukan * 0.3;
            $totalShu = $totalPemasukan - $operationalCost;

            // Get all active users
            $users = User::where('status', 'active')->get();

            foreach ($users as $user) {
                // Calculate user's contribution through savings
                $totalSimpanan = Simpanan::where('user_id', $user->id)
                    ->where('status', 'completed')
                    ->whereYear('created_at', '<=', $request->tahun)
                    ->sum('jumlah');

                // Calculate user's contribution through loans
                $totalPinjaman = Transaksi::where('user_id', $user->id)
                    ->where('jenis_transaksi', 'pinjaman')
                    ->where('status', 'completed')
                    ->whereYear('created_at', $request->tahun)
                    ->sum('jumlah');

                // Calculate contribution percentages
                $kontribusiSimpanan = $totalSimpanan * 0.6; // 60% weight for savings
                $kontribusiPinjaman = $totalPinjaman * 0.4; // 40% weight for loans

                // Calculate individual SHU
                $totalKontribusi = $kontribusiSimpanan + $kontribusiPinjaman;
                $jumlahShu = ($totalKontribusi / $totalPemasukan) * $totalShu;

                // Create SHU record
                Shu::create([
                    'tahun' => $request->tahun,
                    'user_id' => $user->id,
                    'jumlah_shu' => $jumlahShu,
                    'total_simpanan' => $totalSimpanan,
                    'total_pinjaman' => $totalPinjaman,
                    'kontribusi_simpanan' => $kontribusiSimpanan,
                    'kontribusi_pinjaman' => $kontribusiPinjaman,
                    'tanggal_generate' => now()
                ]);
            }

            DB::commit();
            return redirect()->route('admin.shu.index')
                ->with('success', 'SHU berhasil digenerate untuk tahun ' . $request->tahun);

        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat generate SHU: ' . $e->getMessage());
        }
    }
}
