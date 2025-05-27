<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Simpanan;
use App\Models\LoanApplication;
use Illuminate\Support\Facades\Auth;

class RiwayatSimpananController extends Controller
{
    public function index()
    {
        $simpanans = Simpanan::where('user_id', Auth::id())
            ->orderBy('tanggal', 'desc')
            ->get();

        $pinjamans = LoanApplication::where('user_id', Auth::id())
            ->orderBy('application_date', 'desc')
            ->get();

        return view('user.riwayat-simpanan.index', compact('simpanans', 'pinjamans'));
    }
} 