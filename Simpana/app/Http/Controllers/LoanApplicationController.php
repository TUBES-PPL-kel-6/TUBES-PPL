<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use App\Services\NotificationService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


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
        return view('loan-application');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'loan_product' => 'required',
            'loan_amount' => 'required',
            'tenor' => 'required|integer|min:1|max:100',
            'application_date' => 'required|date',
            'first_payment_date' => 'required|date|after_or_equal:application_date',
            'payment_method' => 'required',
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
            'loan_amount' => $loanAmount,
            'tenor' => (int) $request->tenor,
            'application_date' => $request->application_date,
            'first_payment_date' => $request->first_payment_date,
            'payment_method' => $request->payment_method,
            'collateral' => $request->collateral,
            'documents' => $documents,
            'status' => 'pending'
        ]);

        // Create notification for loan application
        NotificationService::createTransactionConfirmation(
            auth()->user(),
            $loanApplication->id,
            $request->loan_amount
        );
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
        $loanApplication->update(['status' => 'approved']);
        return redirect()->route('loanApproval')
            ->with('success', 'Pengajuan pinjaman berhasil disetujui.');
    }

    public function reject(LoanApplication $loanApplication)
    {
        $loanApplication->update(['status' => 'rejected']);
        return redirect()->route('loanApproval')
            ->with('success', 'Pengajuan pinjaman berhasil ditolak.');
    }
}
