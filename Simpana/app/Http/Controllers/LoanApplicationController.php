<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
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
            'loan_product' => 'required|string',
            'loan_amount' => 'required|numeric|min:0',
            'tenor' => 'required|integer|min:1',
            'payment_type' => 'required|in:installment,full_payment'
        ]);

        $loan = LoanApplication::create([
            'user_id' => Auth::id(),
            'loan_product' => $request->loan_product,
            'loan_amount' => $request->loan_amount,
            'tenor' => $request->tenor,
            'payment_type' => $request->payment_type,
            'application_date' => Carbon::now(),
            'first_payment_date' => Carbon::now()->addMonth(),
            'status' => 'pending',
            'remaining_amount' => $request->loan_amount,
            'remaining_installments' => $request->payment_type === 'installment' ? $request->tenor : 1
        ]);

        return redirect()->route('loan.index')->with('success', 'Pengajuan pinjaman berhasil dibuat.');
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
