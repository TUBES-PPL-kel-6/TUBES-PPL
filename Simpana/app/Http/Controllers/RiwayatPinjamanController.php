<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\Auth;

class RiwayatPinjamanController extends Controller
{
    public function index()
    {
        $pinjamans = LoanApplication::with('user')
            ->where('user_id', Auth::id())
            ->orderBy('application_date', 'desc')
            ->get();

        return view('user.riwayat-pinjaman.index', compact('pinjamans'));
    }

    public function store(Request $request)
    {
        // ... validasi dan proses file ...
        LoanApplication::create([
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
        return redirect()->route('user.riwayat-pinjaman.index')
            ->with('success', 'Pengajuan pinjaman berhasil disimpan.');
    }
} 