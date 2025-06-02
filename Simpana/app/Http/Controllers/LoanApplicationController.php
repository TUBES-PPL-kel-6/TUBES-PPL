<?php

 namespace App\Http\Controllers;

 use App\Models\LoanApplication;
 use App\Models\LoanPayment;
 use App\Models\Notification;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Log;
 use Carbon\Carbon;
 use Illuminate\Support\Facades\Response;
 use Barryvdh\DomPDF\Facade\Pdf;
 use Illuminate\Support\Facades\Storage;

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
             // Changed from latest() to oldest() to show first loans first
             $loans = LoanApplication::with('user')->oldest()->paginate(10);
             Log::info('LoanApplicationController@index: Successfully retrieved loans', [
                 'count' => $loans->count()
             ]);
             return view('loanApproval', compact('loans'));
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
            // Fetch the latest loan application for the current user
            $latestLoan = LoanApplication::where('user_id', Auth::id())
                ->whereIn('status', ['approved', 'rejected'])
                ->orderBy('created_at', 'desc')
                ->first();

            // Fetch all loans for the current user - oldest first
            $userLoans = LoanApplication::where('user_id', Auth::id())
                ->orderBy('created_at', 'asc')  // Changed from 'desc' to 'asc'
                ->get();

            return view('loan-application', compact('latestLoan', 'userLoans'));
        }

        /**
         * Store a newly created resource in storage.
         */
        public function store(Request $request)
        {
            // Validate the form data
            $request->validate([
                'user_id' => 'required|exists:users,id',
                'loan_product' => 'required|string',
                'application_note' => 'nullable|string',
                'loan_amount' => 'required|string',  // Using string to handle formatted input
                'tenor' => 'required|integer|min:1|max:100',
                'application_date' => 'required|date',
                'first_payment_date' => 'required|date',
                'collateral' => 'nullable|string',
                'supporting_documents.*' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:10240',  // 10MB limit (10240 KB)

                // HAPUS atau KOMENTARI baris berikut:
                // 'interest_rate' => 'required|numeric|min:0|max:100',
            ], [
                'supporting_documents.*.max' => 'Ukuran file maksimal adalah 10MB per file.',
                'supporting_documents.*.mimes' => 'Format file harus berupa PDF, JPG, JPEG, atau PNG.'
            ]);

            // Process loan amount (remove thousand separators)
            $loanAmount = str_replace('.', '', $request->loan_amount);

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

            // Set bunga flat tetap 1% per bulan
            $defaultInterestRate = 1.00;

            $loanApplication = LoanApplication::create([
                'user_id' => Auth::id(),
                'loan_product' => $request->loan_product,
                'application_note' => $request->application_note,
                'loan_amount' => $loanAmount,
                'tenor' => (int) $request->tenor,
                'application_date' => $request->application_date,
                'first_payment_date' => $request->first_payment_date,
                'payment_method' => 'transfer', // Set a default value or null
                'collateral' => $request->collateral,
                'documents' => $documents,
                'status' => 'pending',
                'interest_rate' => $defaultInterestRate, // sudah benar, ambil dari sistem
            ]);

            return redirect()->route('user.dashboard')->with('success', 'Pengajuan pinjaman berhasil disimpan.');
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
                // 'payment_method' => 'required'
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
                'read_at' => null,
            ]);

            return redirect()->route('loanApproval')
                ->with('success', 'Pengajuan pinjaman berhasil disetujui.');
        }

        private function createPaymentSchedule(LoanApplication $loan)
        {
            if ($loan->payments()->count() > 0) {
                return;
            }
            $monthlyAmount = $loan->getMonthlyInstallmentAmount();
            $dueDate = Carbon::parse($loan->first_payment_date);

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

        public function downloadApprovalLetter(LoanApplication $loanApplication)
        {
            // Check if the loan belongs to the current user (for security)
            if ($loanApplication->user_id !== Auth::id()) {
                abort(403, 'Unauthorized access to loan application');
            }

            // Check if the loan has been approved or rejected
            if (!in_array($loanApplication->status, ['approved', 'rejected'])) {
                return redirect()->back()->with('error', 'Surat persetujuan hanya tersedia untuk pinjaman yang telah disetujui atau ditolak.');
            }

            try {
                // Generate PDF using the blade template
                $pdf = Pdf::loadView('pdf.loan-approval-letter', ['loan' => $loanApplication]);

                // Set paper size and orientation
                $pdf->setPaper('A4', 'portrait');

                // Generate filename
                $filename = 'Surat_Persetujuan_Pinjaman_' . $loanApplication->id . '_' . date('Y-m-d') . '.pdf';

                // Return the PDF as download
                return $pdf->download($filename);

            } catch (\Exception $e) {
                Log::error('Error generating approval letter PDF', [
                    'loan_id' => $loanApplication->id,
                    'error' => $e->getMessage()
                ]);

                return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat surat persetujuan.');
            }
        }

        public function downloadDocument($filename)
        {
            try {
                // Check if file exists in storage
                $filePath = 'documents/' . $filename;

                if (!Storage::disk('public')->exists($filePath)) {
                    abort(404, 'File not found');
                }

                // Get the file path
                $fullPath = Storage::disk('public')->path($filePath);

                // Check if the current user has access to this document
                $hasAccess = LoanApplication::where('user_id', Auth::id())
                    ->whereJsonContains('documents', [['file_name' => $filename]])
                    ->exists();

                if (!$hasAccess) {
                    abort(403, 'Unauthorized access to this document');
                }

                // Return file download
                return response()->download($fullPath);

            } catch (\Exception $e) {
                Log::error('Error downloading document', [
                    'filename' => $filename,
                    'user_id' => Auth::id(),
                    'error' => $e->getMessage()
                ]);

                return redirect()->back()->with('error', 'Terjadi kesalahan saat mengunduh dokumen.');
            }
        }
}
