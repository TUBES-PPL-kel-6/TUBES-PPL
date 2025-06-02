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

        // Total Savings Collected (not Laba)
        $totalSimpananCollected = Simpanan::whereYear('tanggal', $year)
            ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
            ->where('status', 'approved')
            ->sum('jumlah');

        // Total Loan Payments Received (Principal + Interest)
        $payments = LoanPayment::whereYear('payment_date', $year)
            ->where('status', 'verified')
            ->with('loanApplication')
            ->get();
        $totalLoanPaymentsReceived = $payments->sum('amount');

        // Total Calculated Interest (Proxy for Jasa Usaha Income)
        $totalCalculatedInterest = $payments->sum(function($payment) {
            $loan = $payment->loanApplication;
            if (!$loan) return 0;
            // This calculates the interest portion of this specific payment based on the loan's total interest rate
            // Note: A more precise method would be needed for complex interest calculations (e.g., declining balance)
             $monthlyInterestRate = $loan->interest_rate / 100 / 12; // assuming monthly payment & annual rate
             // Simple calculation for interest portion of a payment (approximation for flat rate)
             $principalPerMonth = $loan->loan_amount / $loan->tenor;
             $interestPerMonth = $loan->loan_amount * ($loan->interest_rate / 100 / 12);
             // If the payment amount equals the expected monthly installment, we can use the calculated monthly interest
             if ($payment->amount >= ($principalPerMonth + $interestPerMonth) * 0.95 && $payment->amount <= ($principalPerMonth + $interestPerMonth) * 1.05) { // Allow small tolerance
                 return $interestPerMonth;
             } else {
                 // If payment amount is different (e.g., early repayment), we need a different logic
                 // For simplicity here, we'll just use the calculated monthly interest if it's an installment payment.
                 // A more robust system would calculate exact interest based on remaining principal.
                 return $loan->loan_amount * ($loan->interest_rate / 100 / 12); // Revert to simple monthly interest for now
             }
        });


        // Total Loans Disbursed (Activity Metric, not direct expense against income)
        $totalLoansDisbursed = LoanApplication::whereYear('application_date', $year)
            ->where('status', 'approved')
            ->sum('loan_amount');

        // Simplified Gross Profit (Using Calculated Interest as Income, Ignoring Savings Principal as Income)
        // A real cooperative SHU calculation is more complex, involving operational costs, reserves, etc.
        $simplifiedGrossProfit = $totalCalculatedInterest; // Using calculated interest as primary income source here

        // Data bulanan
        $monthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulanSimpananCollected = Simpanan::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $m)
                ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
                ->where('status', 'approved')
                ->sum('jumlah');

            $bulanPayments = LoanPayment::whereYear('payment_date', $year)
                ->whereMonth('payment_date', $m)
                ->where('status', 'verified')
                ->with('loanApplication')
                ->get();

            $bulanCalculatedInterest = $bulanPayments->sum(function($payment) {
                 $loan = $payment->loanApplication;
                 if (!$loan) return 0;
                  // Simple calculation for interest portion of a payment (approximation for flat rate)
                 $principalPerMonth = $loan->loan_amount / $loan->tenor;
                 $interestPerMonth = $loan->loan_amount * ($loan->interest_rate / 100 / 12);
                 if ($payment->amount >= ($principalPerMonth + $interestPerMonth) * 0.95 && $payment->amount <= ($principalPerMonth + $interestPerMonth) * 1.05) { // Allow small tolerance
                      return $interestPerMonth;
                  } else {
                      return $loan->loan_amount * ($loan->interest_rate / 100 / 12); // Revert to simple monthly interest for now
                  }
            });

            $bulanLoanPaymentsReceived = $bulanPayments->sum('amount');

            $bulanLoansDisbursed = LoanApplication::whereYear('application_date', $year)
                ->whereMonth('application_date', $m)
                ->where('status', 'approved')
                ->sum('loan_amount');

            // Simplified Monthly Gross Profit
             $bulanSimplifiedGrossProfit = $bulanCalculatedInterest; // Using calculated interest as primary income source here

            $monthly[] = [
                'bulan' => $m,
                'simpanan_collected' => $bulanSimpananCollected,
                'loan_payments_received' => $bulanLoanPaymentsReceived,
                'calculated_interest' => $bulanCalculatedInterest,
                'loans_disbursed' => $bulanLoansDisbursed,
                'simplified_gross_profit' => $bulanSimplifiedGrossProfit,
            ];
        }

        return view('admin.profit-report', [
            'year' => $year,
            'totalSimpananCollected' => $totalSimpananCollected,
            'totalLoanPaymentsReceived' => $totalLoanPaymentsReceived,
            'totalCalculatedInterest' => $totalCalculatedInterest,
            'totalLoansDisbursed' => $totalLoansDisbursed,
            'simplifiedGrossProfit' => $simplifiedGrossProfit,
            'monthly' => $monthly,
        ]);
    }

    public function adminDashboard()
    {
        $year = now()->year;

        $monthly = [];
        for ($m = 1; $m <= 12; $m++) {
            $bulanSimpananCollected = Simpanan::whereYear('tanggal', $year)
                ->whereMonth('tanggal', $m)
                ->whereIn('jenis_simpanan', ['pokok', 'wajib', 'sukarela'])
                ->where('status', 'approved')
                ->sum('jumlah');

            // Calculate monthly loan interest income
            $bulanPayments = LoanPayment::whereYear('payment_date', $year)
                ->whereMonth('payment_date', $m)
                ->where('status', 'verified')
                ->with('loanApplication')
                ->get();
            $bulanCalculatedInterest = $bulanPayments->sum(function($payment) {
                $loan = $payment->loanApplication;
                if (!$loan) return 0;
                // Simple calculation for interest portion of a payment (approximation for flat rate)
                 $principalPerMonth = $loan->loan_amount / $loan->tenor;
                 $interestPerMonth = $loan->loan_amount * ($loan->interest_rate / 100 / 12);
                 if ($payment->amount >= ($principalPerMonth + $interestPerMonth) * 0.95 && $payment->amount <= ($principalPerMonth + $interestPerMonth) * 1.05) { // Allow small tolerance
                      return $interestPerMonth;
                  } else {
                      return $loan->loan_amount * ($loan->interest_rate / 100 / 12); // Revert to simple monthly interest for now
                  }
            });

            // Calculate monthly loan principal payments received
            $bulanLoanPaymentsReceived = $bulanPayments->sum('amount');

            $bulanLoansDisbursed = LoanApplication::whereYear('application_date', $year)
                ->whereMonth('application_date', $m)
                ->where('status', 'approved')
                ->sum('loan_amount');

            // Simplified Monthly Gross Profit (Using Calculated Interest as Income)
             $bulanSimplifiedGrossProfit = $bulanCalculatedInterest; // Using calculated interest as primary income source here

            $monthly[] = [
                'bulan' => $m,
                'simpanan_collected' => $bulanSimpananCollected,
                'loan_payments_received' => $bulanLoanPaymentsReceived,
                'calculated_interest' => $bulanCalculatedInterest,
                'loans_disbursed' => $bulanLoansDisbursed,
                'simplified_gross_profit' => $bulanSimplifiedGrossProfit,
            ];
        }

         // You might also want to calculate the total simplifiedGrossProfit for the year
         $simplifiedGrossProfit = array_sum(array_column($monthly, 'simplified_gross_profit'));

        return view('admin_dashboard', compact('monthly', 'year', 'simplifiedGrossProfit'));
    }
}
