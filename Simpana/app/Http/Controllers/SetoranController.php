<?php

namespace App\Http\Controllers;

use App\Models\Setoran;
use Illuminate\Http\Request;

class SetoranController extends Controller
{
    public function index()
    {
        $setorans = Setoran::all();
        return view('setoran.index', compact('setorans'));
    }


    public function create()
    {
        return view('setoran.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'jumlah_setoran' => 'required|numeric',
            'tanggal_setor' => 'nullable|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        Setoran::create($request->all());

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $setoran = Setoran::findOrFail($id);
        return view('setoran.edit', compact('setoran'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_anggota' => 'required|string|max:255',
            'jumlah_setoran' => 'required|numeric',
            'tanggal_setor' => 'nullable|date',
            'keterangan' => 'nullable|string|max:500',
        ]);

        $setoran = Setoran::findOrFail($id);
        $setoran->update($request->all());

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $setoran = Setoran::findOrFail($id);
        $setoran->delete();

        return redirect()->route('setoran.index')->with('success', 'Setoran berhasil dihapus!');
    }
}
