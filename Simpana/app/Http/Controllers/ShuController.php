<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Simpanan;
use App\Models\Pinjaman;

class ShuController extends Controller
{
    public function index()
    {
        // Get SHU data grouped by year
        $shus = \App\Models\Shu::with('user')
            ->orderBy('tahun', 'desc')
            ->get()
            ->groupBy('tahun');

        return view('admin.shu.index', compact('shus'));
    }

    public function showGenerateForm()
    {
        return view('admin.shu.generate');
    }

    public function generate(Request $request)
    {
        $request->validate([
            'tahun' => 'required|integer|min:2020|max:' . date('Y')
        ]);

        try {
            // Get all transactions for the year
            $totalSimpanan = Simpanan::whereYear('created_at', $request->tahun)
                ->where('status', 'completed')
                ->sum('jumlah');

            $totalPinjaman = Pinjaman::whereYear('created_at', $request->tahun)
                ->where('status', 'approved')
                ->sum('amount');

            // Calculate SHU (10% from total pinjaman as example)
            $shu = $totalPinjaman * 0.1;

            // Get all users with transactions
            $users = \App\Models\User::whereHas('simpanan', function($query) use ($request) {
                $query->whereYear('created_at', $request->tahun);
            })->orWhereHas('pinjaman', function($query) use ($request) {
                $query->whereYear('created_at', $request->tahun);
            })->get();

            foreach($users as $user) {
                // Calculate individual contributions
                $userSimpanan = $user->simpanan()
                    ->whereYear('created_at', $request->tahun)
                    ->where('status', 'completed')
                    ->sum('jumlah');

                $userPinjaman = $user->pinjaman()
                    ->whereYear('created_at', $request->tahun)
                    ->where('status', 'approved')
                    ->sum('amount');

                // Create or update SHU record
                \App\Models\Shu::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'tahun' => $request->tahun
                    ],
                    [
                        'total_simpanan' => $userSimpanan,
                        'total_pinjaman' => $userPinjaman,
                        'kontribusi_simpanan' => $totalSimpanan > 0 ? ($userSimpanan / $totalSimpanan) * ($shu * 0.4) : 0,
                        'kontribusi_pinjaman' => $totalPinjaman > 0 ? ($userPinjaman / $totalPinjaman) * ($shu * 0.6) : 0,
                        'jumlah_shu' => 0, // Will be calculated below
                    ]
                );
            }

            // Update total SHU for each user
            $shus = \App\Models\Shu::where('tahun', $request->tahun)->get();
            foreach($shus as $shuRecord) {
                $shuRecord->jumlah_shu = $shuRecord->kontribusi_simpanan + $shuRecord->kontribusi_pinjaman;
                $shuRecord->save();
            }

            return redirect()->route('admin.shu.index')->with('success', 'SHU berhasil digenerate untuk tahun ' . $request->tahun);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generatePDF(Request $request)
    {
        $year = $request->tahun ?? date('Y');

        // Get total pendapatan
        $totalPinjaman = Transaksi::whereYear('created_at', $year)
            ->where('jenis_transaksi', 'pinjaman')
            ->where('status', 'completed')
            ->sum('jumlah');

        $bungaPinjaman = $totalPinjaman * 0.1; // 10% bunga
        $totalSHU = $bungaPinjaman;

        // Pembagian SHU
        $komponenPembagian = [
            [
                'no' => 1,
                'komponen' => 'Jasa Modal (berdasarkan simpanan)',
                'persentase' => 40,
                'jumlah' => $totalSHU * 0.4
            ],
            [
                'no' => 2,
                'komponen' => 'Jasa Usaha (berdasarkan pinjaman)',
                'persentase' => 40,
                'jumlah' => $totalSHU * 0.4
            ],
            [
                'no' => 3,
                'komponen' => 'Dana Sosial',
                'persentase' => 10,
                'jumlah' => $totalSHU * 0.1
            ],
            [
                'no' => 4,
                'komponen' => 'Dana Cadangan Koperasi',
                'persentase' => 10,
                'jumlah' => $totalSHU * 0.1
            ]
        ];

        $data = [
            'tahun' => $year,
            'totalPinjaman' => $totalPinjaman,
            'bungaPinjaman' => $bungaPinjaman,
            'totalSHU' => $totalSHU,
            'komponenPembagian' => $komponenPembagian
        ];

        $pdf = PDF::loadView('admin.shu.pdf', $data);

        return $pdf->download('laporan-shu-'.$year.'.pdf');
    }
}
