<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class EarlyRepaymentController extends Controller
{
    public function show($id)
    {
        $loan = LoanApplication::findOrFail($id);
        
        // Verify that the loan belongs to the current user
        if ($loan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pinjaman ini.');
        }

        // Calculate remaining amount
        $remainingAmount = $this->calculateRemainingAmount($loan);
        
        return view('early-repayment', compact('loan', 'remainingAmount'));
    }

    public function process(Request $request, $id)
    {
        $loan = LoanApplication::findOrFail($id);
        
        // Verify that the loan belongs to the current user
        if ($loan->user_id !== Auth::id()) {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses ke pinjaman ini.');
        }

        $request->validate([
            'payment_method' => 'required',
            'amount' => 'required|numeric|min:0'
        ]);

        // Calculate remaining amount
        $remainingAmount = $this->calculateRemainingAmount($loan);

        // Verify payment amount
        if ($request->amount != $remainingAmount) {
            return redirect()->back()->with('error', 'Jumlah pembayaran tidak sesuai dengan sisa pinjaman.');
        }

        // Process payment
        try {
            // Update loan status
            $loan->update([
                'status' => 'completed',
                'completed_at' => now(),
                'payment_method' => $request->payment_method
            ]);

            // Log payment
            Log::info('Early repayment processed', [
                'user_id' => Auth::id(),
                'loan_id' => $loan->id,
                'amount' => $remainingAmount,
                'payment_method' => $request->payment_method
            ]);

            return redirect()->route('loan.show', $loan->id)
                ->with('success', 'Pembayaran pelunasan awal berhasil diproses.');
        } catch (\Exception $e) {
            Log::error('Error processing early repayment', [
                'error' => $e->getMessage(),
                'loan_id' => $loan->id
            ]);
            
            return redirect()->back()->with('error', 'Terjadi kesalahan saat memproses pembayaran.');
        }
    }

    private function calculateRemainingAmount($loan)
    {
        // Calculate total amount to be paid
        $totalAmount = $loan->loan_amount;
        
        // Calculate interest (assuming 10% per year)
        $interestRate = 0.10;
        $years = $loan->tenor / 12; // Convert months to years
        $totalWithInterest = $totalAmount * (1 + ($interestRate * $years));
        
        // Calculate remaining amount (assuming no payments made yet)
        return $totalWithInterest;
    }
}