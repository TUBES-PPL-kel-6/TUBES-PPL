<?php

namespace App\Http\Controllers;

use App\Models\Pinjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PinjamanController extends Controller
{
    public function index()
    {
        $pinjaman = Pinjaman::where('user_id', Auth::id())->get();
        return view('user.riwayat-pinjaman', compact('pinjaman'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jumlah_pinjaman' => 'required|numeric',
            'tanggal_pinjaman' => 'required|date',
            'tanggal_pengembalian' => 'required|date|after:tanggal_pinjaman',
            'keterangan' => 'nullable|string'
        ]);

        Pinjaman::create([
            'user_id' => Auth::id(),
            'jumlah_pinjaman' => $request->jumlah_pinjaman,
            'tanggal_pinjaman' => $request->tanggal_pinjaman,
            'tanggal_pengembalian' => $request->tanggal_pengembalian,
            'status' => 'pending',
            'keterangan' => $request->keterangan
        ]);

        return redirect()->back()->with('success', 'Data pinjaman berhasil disimpan');
    }
} 