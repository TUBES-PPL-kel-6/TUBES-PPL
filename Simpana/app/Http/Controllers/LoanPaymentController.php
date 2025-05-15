<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use App\Models\LoanPayment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class LoanPaymentController extends Controller
{
    /**
     * Display a list of the user's loan payments
     */
    public function index()
    {
        $loanApplications = LoanApplication::where('user_id', Auth::id())
            ->where('status', 'approved')
            ->with('payments')
            ->get();
            
        return view('loan-payments.index', compact('loanApplications'));
    }
    
    /**
     * Display the form to make a payment for a specific loan
     */
    public function create(LoanApplication $loan)
    {
        // Verify the loan belongs to the user and is approved
        if ($loan->user_id !== Auth::id() || $loan->status !== 'approved') {
            return redirect()->route('loan-payments.index')
                ->with('error', 'Anda tidak memiliki akses ke pinjaman ini.');
        }
        
        // Get the next payment number
        $nextPaymentNumber = $loan->payments()->count() + 1;
        
        // Calculate monthly installment
        $monthlyPayment = $loan->getMonthlyInstallmentAmount();
        
        // Calculate due date (first payment date + (payment number - 1) months)
        $firstPaymentDate = $loan->first_payment_date;
        $dueDate = Carbon::parse($firstPaymentDate)->addMonths($nextPaymentNumber - 1);
        
        return view('loan-payments.create', compact('loan', 'nextPaymentNumber', 'monthlyPayment', 'dueDate'));
    }
    
    /**
     * Store a new loan payment
     */
    public function store(Request $request, LoanApplication $loan)
    {
        // Validate request
        $request->validate([
            'payment_method' => 'required|in:transfer,cash,debit',
            'payment_proof' => 'required_if:payment_method,transfer|file|mimes:jpeg,png,jpg,pdf|max:2048',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:1'
        ]);
        
        // Verify the loan belongs to the user and is approved
        if ($loan->user_id !== Auth::id() || $loan->status !== 'approved') {
            return redirect()->route('loan-payments.index')
                ->with('error', 'Anda tidak memiliki akses ke pinjaman ini.');
        }
        
        // Get payment info
        $nextPaymentNumber = $loan->payments()->count() + 1;
        $dueDate = Carbon::parse($loan->first_payment_date)->addMonths($nextPaymentNumber - 1);
        
        // Handle file upload if payment method is transfer
        $paymentProofPath = null;
        if ($request->payment_method === 'transfer' && $request->hasFile('payment_proof')) {
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $paymentProofPath = $file->storeAs('public/payment_proofs', $fileName);
        }
        
        // Create payment
        $payment = LoanPayment::create([
            'loan_application_id' => $loan->id,
            'amount' => $request->amount,
            'installment_number' => $nextPaymentNumber,
            'payment_date' => $request->payment_date,
            'due_date' => $dueDate,
            'payment_method' => $request->payment_method,
            'payment_proof' => $paymentProofPath,
            'status' => ($request->payment_method === 'transfer') ? 'pending' : 'paid', // If transfer, status is pending until verified
            'notes' => $request->notes
        ]);
        
        // Create notification for admin to verify payment
        if ($request->payment_method === 'transfer') {
            Notification::create([
                'user_id' => 1, // Admin ID
                'title' => 'Pembayaran Pinjaman Baru',
                'message' => 'Pembayaran pinjaman baru dari ' . Auth::user()->name . ' perlu verifikasi.',
                'type' => 'pinjaman',
                'is_read' => false
            ]);
        }
        
        return redirect()->route('loan-payments.index')
            ->with('success', 'Pembayaran angsuran berhasil disimpan.');
    }
    
    /**
     * Show all payments for admin verification
     */
    public function adminVerification()
    {
        $pendingPayments = LoanPayment::where('status', 'pending')
            ->with(['loanApplication', 'loanApplication.user'])
            ->latest()
            ->paginate(10);
            
        return view('admin.payment-verification', compact('pendingPayments'));
    }
    
    /**
     * Verify a payment (admin only)
     */
    public function verify(LoanPayment $payment)
    {
        $payment->update([
            'status' => 'verified'
        ]);
        
        // Notify user that payment has been verified
        Notification::create([
            'user_id' => $payment->loanApplication->user_id,
            'title' => 'Pembayaran Diverifikasi',
            'message' => 'Pembayaran angsuran ke-' . $payment->installment_number . ' telah diverifikasi.',
            'type' => 'pinjaman',
            'is_read' => false
        ]);
        
        return redirect()->route('admin.payment-verification')
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }
    
    /**
     * Reject a payment (admin only)
     */
    public function reject(Request $request, LoanPayment $payment)
    {
        $request->validate([
            'rejection_reason' => 'required|string'
        ]);
        
        $payment->update([
            'status' => 'pending',
            'notes' => $request->rejection_reason
        ]);
        
        // Notify user that payment was rejected
        Notification::create([
            'user_id' => $payment->loanApplication->user_id,
            'title' => 'Pembayaran Ditolak',
            'message' => 'Pembayaran angsuran ke-' . $payment->installment_number . ' ditolak: ' . $request->rejection_reason,
            'type' => 'pinjaman',
            'is_read' => false
        ]);
        
        return redirect()->route('admin.payment-verification')
            ->with('success', 'Pembayaran ditolak dan pemberitahuan telah dikirim.');
    }
}