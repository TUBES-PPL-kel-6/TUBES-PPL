<?php
namespace App\Http\Controllers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Simpanan;
use App\Models\Pinjaman;
use App\Models\LoanPayment;
use App\Models\LoanApplication;

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
            // Total bunga pinjaman (hasil usaha koperasi)
            $payments = \App\Models\LoanPayment::whereYear('payment_date', $request->tahun)
                ->where('status', 'verified')
                ->with('loanApplication')
                ->get();
            $totalInterest = $payments->sum(function($payment) {
                $loan = $payment->loanApplication;
                if (!$loan) return 0;
                return $loan->loan_amount * ($loan->interest_rate / 100);
            });
            $totalSHU = $totalInterest;

            // Total simpanan & pinjaman anggota (untuk proporsi pembagian)
            $totalSimpanan = \App\Models\Simpanan::whereYear('tanggal', $request->tahun)
                ->where('status', 'approved')
                ->sum('jumlah');
            $totalPinjaman = \App\Models\LoanApplication::whereYear('application_date', $request->tahun)
                ->where('status', 'approved')
                ->sum('loan_amount');

            // Get all users
            $users = \App\Models\User::all();
            foreach($users as $user) {
                $userSimpanan = $user->simpanans()
                    ->whereYear('tanggal', $request->tahun)
                    ->where('status', 'approved')
                    ->sum('jumlah');
                $userPinjaman = $user->loanApplications()
                    ->whereYear('application_date', $request->tahun)
                    ->where('status', 'approved')
                    ->sum('loan_amount');

                $kontribusiSimpanan = $totalSimpanan > 0 ? ($userSimpanan / $totalSimpanan) * ($totalSHU * 0.4) : 0;
                $kontribusiPinjaman = $totalPinjaman > 0 ? ($userPinjaman / $totalPinjaman) * ($totalSHU * 0.6) : 0;
                $jumlah_shu = $kontribusiSimpanan + $kontribusiPinjaman;

                \App\Models\Shu::updateOrCreate(
                    [
                        'user_id' => $user->id,
                        'tahun' => $request->tahun
                    ],
                    [
                        'total_simpanan' => $userSimpanan,
                        'total_pinjaman' => $userPinjaman,
                        'kontribusi_simpanan' => $kontribusiSimpanan,
                        'kontribusi_pinjaman' => $kontribusiPinjaman,
                        'jumlah_shu' => $jumlah_shu,
                        'tanggal_generate' => now(),
                    ]
                );
            }

            return redirect()->route('admin.shu.index')->with('success', 'SHU berhasil digenerate untuk tahun ' . $request->tahun);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function generatePDF(Request $request)
    {
        $year = $request->tahun ?? date('Y');

        // Get all verified payments for the year
        $payments = LoanPayment::whereYear('payment_date', $year)
            ->where('status', 'verified')
            ->with('loanApplication')
            ->get();
        $totalInterest = $payments->sum(function($payment) {
            $loan = $payment->loanApplication;
            if (!$loan) return 0;
            return $loan->loan_amount * ($loan->interest_rate / 100);
        });
        $totalSHU = $totalInterest;

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

        $shus = \App\Models\Shu::where('tahun', $year)->with('user')->get();

        $data = [
            'tahun' => $year,
            'totalPinjaman' => null,
            'bungaPinjaman' => $totalInterest,
            'totalSHU' => $totalSHU,
            'komponenPembagian' => $komponenPembagian,
            'shus' => $shus,
        ];

        $pdf = PDF::loadView('admin.shu.pdf', $data);
        return $pdf->download('laporan-shu-'.$year.'.pdf');
    }
}
