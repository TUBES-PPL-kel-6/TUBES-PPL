<?php

 namespace App\Http\Controllers;

 use App\Models\LoanApplication;
 use App\Models\LoanPayment;
 use App\Models\Notification;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Log;
 use Carbon\Carbon;

 class LoanApplicationController extends Controller
 {
     /**
      * Display a listing of the resource.
      */
     public function index()
     {
         Log::info('LoanApplicationController@index: Accessing loan approval page', [
             'user_id' => Auth::id(),
             'role' => Auth::user() ? Auth::user()->role : 'not logged in'
         ]);

        try {
            $loans = LoanApplication::with('user')->latest()->paginate(10);
            Log::info('LoanApplicationController@index: Successfully retrieved loans', [
                'count' => $loans->count()
            ]);
            return view('admin.loan-approval', compact('loans'));
        } catch (\Exception $e) {
            Log::error('LoanApplicationController@index: Error retrieving loans', [
                'error' => $e->getMessage()
            ]);
            return back()->with('error', 'Error loading loan applications');
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('loan-application');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $request->validate([
                'loan_product' => 'required|in:pendidikan,usaha,konsumtif',
                'loan_amount' => 'required|numeric|min:100000|max:100000000',
                'tenor' => 'required|integer|min:1|max:100',
                'application_date' => 'required|date',
                'first_payment_date' => 'required|date|after_or_equal:application_date',
                'payment_method' => 'required|in:cash,transfer,debit',
                'supporting_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:2048'
            ]);

            // Handle file uploads
            $documents = [];
            if ($request->hasFile('supporting_documents')) {
                foreach ($request->file('supporting_documents') as $file) {
                    $fileName = time() . '_' . $file->getClientOriginalName();
                    $file->storeAs('public/documents', $fileName);

                    $documents[] = [
                        'file_name' => $fileName,
                        'original_name' => $file->getClientOriginalName(),
                        'file_path' => 'storage/documents/' . $fileName
                    ];
                }
            }

            // Format loan amount - remove dots and convert to integer
            $loanAmount = str_replace('.', '', $request->loan_amount);
            $loanAmount = (int) $loanAmount;

            // Create loan application
            $loanApplication = LoanApplication::create([
                'user_id' => Auth::id(),
                'loan_product' => $request->loan_product,
                'application_note' => $request->application_note,
                'loan_amount' => $request->loan_amount,
                'tenor' => (int) $request->tenor,
                'application_date' => $request->application_date,
                'first_payment_date' => $request->first_payment_date,
                'payment_method' => $request->payment_method,
                'collateral' => $request->collateral,
                'documents' => $documents,
                'status' => 'pending'
            ]);

            return redirect()->route('user.dashboard')
                ->with('success', 'Pengajuan pinjaman berhasil disimpan.');
        }

    /**
     * Display the specified resource.
     */
    public function show(LoanApplication $loanApplication)
    {
        // Tampilkan detail pinjaman untuk halaman detail
        return view('loan-detail', compact('loanApplication'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LoanApplication $loanApplication)
    {
        return view('loan-application', compact('loanApplication'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LoanApplication $loanApplication)
    {
        $request->validate([
            'loan_product' => 'required',
            'loan_amount' => 'required|numeric',
            'tenor' => 'required|integer',
            'application_date' => 'required|date',
            'first_payment_date' => 'required|date',
            'payment_method' => 'required'
        ]);

        $loanApplication->update($request->all());

        return redirect()->route('loan.create')
            ->with('success', 'Pengajuan pinjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanApplication $loanApplication)
    {
        $loanApplication->delete();

        return redirect()->route('loan.create')
            ->with('success', 'Pengajuan pinjaman berhasil dihapus.');
    }

        public function approve(LoanApplication $loanApplication)
        {
            // Update loan status
            $loanApplication->update(['status' => 'approved']);

            // Create payment schedule ONLY if it doesn't exist yet
            if ($loanApplication->payments()->count() == 0) {
                $this->createPaymentSchedule($loanApplication);
            }

            // Notify user
            Notification::create([
                'user_id' => $loanApplication->user_id,
                'title' => 'Pinjaman Disetujui',
                'message' => 'Pengajuan pinjaman Anda telah disetujui.',
                'type' => 'pinjaman',
                'is_read' => false
            ]);

            return redirect()->route('loanApproval')
                ->with('success', 'Pengajuan pinjaman berhasil disetujui.');
        }

        private function createPaymentSchedule(LoanApplication $loan)
        {
            // Double check - prevent duplicate schedules
            if ($loan->payments()->count() > 0) {
                return; // Schedule already exists
            }

            // Calculate monthly installment amount
            $monthlyAmount = $loan->loan_amount / $loan->tenor;

            // Get first payment date
            $dueDate = Carbon::parse($loan->first_payment_date);

            // Create payments for each month of the tenor
            for ($i = 1; $i <= $loan->tenor; $i++) {
                LoanPayment::create([
                    'loan_application_id' => $loan->id,
                    'amount' => $monthlyAmount,
                    'installment_number' => $i,
                    'payment_date' => null,
                    'due_date' => $dueDate->copy(),
                    'payment_method' => null,
                    'status' => 'pending'
                ]);

                // Move due date to next month
                $dueDate->addMonth();
            }
        }

        public function reject(LoanApplication $loanApplication)
        {
            $loanApplication->update(['status' => 'rejected']);
            return redirect()->route('loanApproval')
                ->with('success', 'Pengajuan pinjaman berhasil ditolak.');
        }

        /**
         * Clean up duplicate payments - EMERGENCY FIX
         */
        public function cleanupDuplicatePayments(LoanApplication $loan)
        {
            // Get all payments grouped by installment number
            $payments = $loan->payments()->orderBy('installment_number')->orderBy('created_at')->get();

            $seenInstallments = [];
            $toDelete = [];

            foreach ($payments as $payment) {
                if (in_array($payment->installment_number, $seenInstallments)) {
                    // This is a duplicate, mark for deletion
                    $toDelete[] = $payment->id;
                } else {
                    // First occurrence, keep it
                    $seenInstallments[] = $payment->installment_number;
                }
            }

            // Delete duplicates
            if (!empty($toDelete)) {
                LoanPayment::whereIn('id', $toDelete)->delete();
            }

            return redirect()->back()->with('success', 'Duplicate payments cleaned up successfully.');
        }
}
