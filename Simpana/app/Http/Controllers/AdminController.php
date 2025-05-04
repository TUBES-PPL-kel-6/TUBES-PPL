<?php

namespace App\Http\Controllers;

use App\Models\LoanApplication;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $pendingLoans = LoanApplication::where('status', 'pending')->count();
        $totalLoans = LoanApplication::count();

        return view('admin_dashboard', compact('pendingLoans', 'totalLoans'));
    }
}
