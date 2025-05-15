<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Simpanan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetoranController extends Controller
{
    public function index()
    {
        $setorans = Simpanan::with('user')
            ->orderBy('tanggal', 'desc')
            ->get();

        return view('admin.setoran.index', compact('setorans'));
    }

    public function create()
    {
        $users = User::where('role', 'user')->get();
        return view('admin.setoran.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        // Handle the form input from number format to database format
        $jumlah = $request->jumlah;
        if (is_string($jumlah)) {
            $jumlah = str_replace('.', '', $jumlah); // Remove thousand separators
            $jumlah = str_replace(',', '.', $jumlah); // Replace comma with dot for decimal
        }

        Simpanan::create([
            'user_id' => $request->user_id,
            'jenis_simpanan' => $request->jenis_simpanan,
            'jumlah' => $jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan,
            'status' => 'diterima'
        ]);

        return redirect()->route('admin.setoran.index')
            ->with('success', 'Setoran berhasil ditambahkan');
    }

    public function edit(Simpanan $setoran)
    {
        $users = User::where('role', 'user')->get();
        return view('admin.setoran.edit', compact('setoran', 'users'));
    }

    public function update(Request $request, Simpanan $setoran)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        // Handle the form input from number format to database format
        $jumlah = $request->jumlah;
        if (is_string($jumlah)) {
            $jumlah = str_replace('.', '', $jumlah); // Remove thousand separators
            $jumlah = str_replace(',', '.', $jumlah); // Replace comma with dot for decimal
        }

        $setoran->update([
            'user_id' => $request->user_id,
            'jenis_simpanan' => $request->jenis_simpanan,
            'jumlah' => $jumlah,
            'tanggal' => $request->tanggal,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('admin.setoran.index')
            ->with('success', 'Setoran berhasil diperbarui');
    }

    public function destroy(Simpanan $setoran)
    {
        $setoran->delete();
        return redirect()->route('admin.setoran.index')
            ->with('success', 'Setoran berhasil dihapus');
    }
} 



    $simpanan = \App\Models\Simpanan::findOrFail($id);
    return view('admin.setoran.edit', compact('simpanan'));
