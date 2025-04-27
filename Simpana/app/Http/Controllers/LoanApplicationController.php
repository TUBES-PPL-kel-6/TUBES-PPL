<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;
use App\Services\NotificationService;

class LoanApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $loans = LoanApplication::latest()->get();
        return view('loan-application', compact('loans'));
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
            'loan_amount' => 'required|numeric',
            'tenor' => 'required|integer',
            'application_date' => 'required|date',
            'first_payment_date' => 'required|date',
            'payment_method' => 'required'
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

        // Create loan application
        $loanApplication = LoanApplication::create([
            'loan_product' => $request->loan_product,
            'application_note' => $request->application_note,
            'loan_amount' => $request->loan_amount,
            'tenor' => $request->tenor,
            'application_date' => $request->application_date,
            'first_payment_date' => $request->first_payment_date,
            'payment_method' => $request->payment_method,
            'collateral' => $request->collateral,
            'documents' => $documents
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
        return view('loan-application', compact('loanApplication'));
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

        return redirect()->route('loan-application')
            ->with('success', 'Pengajuan pinjaman berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LoanApplication $loanApplication)
    {
        $loanApplication->delete();

        return redirect()->route('loan-application')
            ->with('success', 'Pengajuan pinjaman berhasil dihapus.');
    }
}