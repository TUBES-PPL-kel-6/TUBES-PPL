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

        // Find the next unpaid payment (either pending or rejected)
        $nextPayment = $loan->payments()
            ->whereNull('payment_date')
            ->where('status', 'pending')
            ->orderBy('installment_number')
            ->first();
            
        if (!$nextPayment) {
            // If no pending payment, check for rejected payments
            $nextPayment = $loan->payments()
                ->where('status', 'rejected')
                ->orderBy('installment_number')
                ->first();
        }

        if (!$nextPayment) {
            return redirect()->route('loan-payments.index')
                ->with('success', 'Semua angsuran sudah lunas!');
        }

        $nextPaymentNumber = $nextPayment->installment_number;
        $monthlyPayment = $nextPayment->amount;
        $dueDate = $nextPayment->due_date;
        $rejectionReason = $nextPayment->status === 'rejected' ? $nextPayment->notes : null;

        // This will ensure the form is rendered with the "Bayar Angsuran" style but can include rejection info
        return view('loan-payments.create', compact('loan', 'nextPaymentNumber', 'monthlyPayment', 'dueDate', 'rejectionReason'));
    }

    /**
     * Store a new loan payment or update a rejected one
     */
    public function store(Request $request, LoanApplication $loan)
    {
        // Validate request
        $request->validate([
            'payment_method' => 'required|in:transfer,cash,debit',
            'payment_proof' => 'required_if:payment_method,transfer|file|mimes:jpeg,png,jpg|max:11000',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric|min:1',
            'payment_id' => 'nullable|exists:loan_payments,id' // Add validation for payment_id
        ]);

        // Verify the loan belongs to the user and is approved
        if ($loan->user_id !== Auth::id() || $loan->status !== 'approved') {
            return redirect()->route('loan-payments.index')
                ->with('error', 'Anda tidak memiliki akses ke pinjaman ini.');
        }

        // If payment_id is provided, find that specific payment instead of the first one
        $nextPayment = null;
        if ($request->has('payment_id') && $request->payment_id) {
            $nextPayment = LoanPayment::where('id', $request->payment_id)
                ->where('loan_application_id', $loan->id)
                ->first();
                
            if (!$nextPayment || $nextPayment->status !== 'rejected') {
                return redirect()->route('loan-payments.index')
                    ->with('error', 'Pembayaran yang ingin diajukan ulang tidak valid.');
            }
        } else {
            // Normal flow for regular payments: Find the next unpaid payment
            $nextPayment = $loan->payments()
                ->whereNull('payment_date')
                ->where('status', 'pending')
                ->orderBy('installment_number')
                ->first();
                
            if (!$nextPayment) {
                // If no pending payment, check for rejected payments
                $nextPayment = $loan->payments()
                    ->where('status', 'rejected')
                    ->orderBy('installment_number')
                    ->first();
            }
        }

        if (!$nextPayment) {
            return redirect()->route('loan-payments.index')
                ->with('error', 'Tidak ada angsuran yang perlu dibayar.');
        }

        // Handle file upload if payment method is transfer
        $paymentProofPath = null;
        if ($request->payment_method === 'transfer' && $request->hasFile('payment_proof')) {
            // Remove old payment proof if it exists
            if ($nextPayment->payment_proof) {
                Storage::delete($nextPayment->payment_proof);
            }
            
            $file = $request->file('payment_proof');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $paymentProofPath = $file->storeAs('public/payment_proofs', $fileName);
        }

        // Format amount - langsung cast ke float
        $amount = floatval($request->amount);

        // Determine payment status based on payment method
        $paymentStatus = 'pending';
        if ($request->payment_method === 'cash' || $request->payment_method === 'debit') {
            $paymentStatus = 'verified'; // Cash and debit payments are immediately considered verified
        }

        // Cek jenis pembayaran
        $paymentType = $request->input('payment_type', 'installment');

        if ($paymentType === 'full') {
            // Update all pending installments to paid status
            $loan->payments()
                ->whereIn('status', ['pending', 'rejected'])
                ->update([
                    'payment_date' => $request->payment_date,
                    'payment_method' => $request->payment_method,
                    'payment_proof' => $paymentProofPath ?? null,
                    'status' => $paymentStatus,
                    'notes' => $request->notes,
                    'payment_type' => 'full'
                ]);
        } else {
            // UPDATE THE EXISTING PAYMENT instead of creating a new one
            $nextPayment->update([
                'payment_date' => $request->payment_date,
                'payment_method' => $request->payment_method,
                'payment_proof' => $paymentProofPath ?? null,
                'status' => $paymentStatus,
                'notes' => $request->notes
            ]);
        }

        // Create notification for admin if payment needs verification
        if ($request->payment_method === 'transfer') {
            Notification::create([
                'user_id' => 1, // Admin ID - you might want to make this dynamic
                'title' => 'Pembayaran Pinjaman Baru',
                'message' => 'Pembayaran angsuran ke-' . $nextPayment->installment_number . ' perlu verifikasi.',
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
            ->where('payment_method', 'transfer')
            ->with(['loanApplication.user'])
            ->orderByDesc('created_at')
            ->paginate(10);

        return view('admin.payment-verification', compact('pendingPayments'));
    }

    /**
     * Verify a payment (admin only)
     */
    public function verify(Request $request, LoanPayment $payment)
    {
        if ($payment->status !== 'pending') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Pembayaran ini sudah diproses.'], 400);
            }
            return redirect()->route('admin.payment-verification')
                ->with('error', 'Pembayaran ini sudah diproses.');
        }
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

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.payment-verification')
            ->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /**
     * Reject a payment (admin only)
     */
    public function reject(Request $request, LoanPayment $payment)
    {
        if ($payment->status !== 'pending') {
            if ($request->ajax()) {
                return response()->json(['error' => 'Pembayaran ini sudah diproses.'], 400);
            }
            return redirect()->route('admin.payment-verification')
                ->with('error', 'Pembayaran ini sudah diproses.');
        }
        $request->validate([
            'rejection_reason' => 'required|string'
        ]);

        $payment->update([
            'status' => 'rejected',
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

        if ($request->ajax()) {
            return response()->json(['success' => true]);
        }
        return redirect()->route('admin.payment-verification')
            ->with('success', 'Pembayaran ditolak dan pemberitahuan telah dikirim.');
    }

    /**
     * Get payment details for a specific payment
     */
    public function getPaymentDetails(LoanPayment $payment)
    {
        return response()->json([
            'id' => $payment->id,
            'user_name' => $payment->loanApplication->user->name ?? '-',
            'loan_application_id' => $payment->loan_application_id,
            'installment_number' => $payment->installment_number,
            'amount' => $payment->amount,
            'payment_date' => optional($payment->payment_date)->format('d/m/Y'),
            'due_date' => optional($payment->due_date)->format('d/m/Y'),
            'payment_method' => $payment->payment_method,
            'payment_proof' => $payment->payment_proof ? asset(str_replace('public/', 'storage/', $payment->payment_proof)) : null,
            'notes' => $payment->notes,
        ]);
    }

    /**
     * Show form to resubmit a rejected payment
     */
    public function resubmit(LoanPayment $payment)
    {
        // Verify the payment belongs to the user and is rejected
        if ($payment->loanApplication->user_id !== Auth::id() || $payment->status !== 'rejected') {
            return redirect()->route('loan-payments.index')
                ->with('error', 'Anda tidak memiliki akses ke pembayaran ini atau pembayaran tidak ditolak.');
        }

        $loan = $payment->loanApplication;
        $nextPaymentNumber = $payment->installment_number;
        $monthlyPayment = $payment->amount;
        $dueDate = $payment->due_date;
        $rejectionReason = $payment->notes;
        
        // Set the page title to match the "Bayar Angsuran" style
        $pageTitle = "Bayar Angsuran";
        $isResubmission = true;
        
        // Pass the payment ID to the view for the form action
        $paymentId = $payment->id;
        
        return view('loan-payments.create', compact(
            'loan', 
            'payment',
            'paymentId',
            'nextPaymentNumber', 
            'monthlyPayment', 
            'dueDate', 
            'rejectionReason',
            'pageTitle',
            'isResubmission'
        ));
    }
}
