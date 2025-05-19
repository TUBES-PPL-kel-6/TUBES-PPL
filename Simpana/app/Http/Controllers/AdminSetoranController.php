<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Simpanan;
use Illuminate\Support\Facades\DB;

class AdminSetoranController extends Controller
{
    public function index()
    {
        $simpanans = Simpanan::with(['user' => function($query) {
            $query->select('id', 'nama');
        }])->orderBy('tanggal', 'desc')->get();
        $users = \App\Models\User::where('role', 'member')->select('id', 'nama')->get();
        return view('admin.setoran.index', compact('simpanans', 'users'));
    }

    public function edit($id)
    {
        $simpanan = Simpanan::with('user')->findOrFail($id);
        $users = \App\Models\User::where('role', 'member')->get();
        return view('admin.setoran.edit', compact('simpanan', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();
            
            $simpanan = Simpanan::with('user')->findOrFail($id);
            
            // Update nama user
            $simpanan->user->update([
                'nama' => $request->nama
            ]);
            
            // Update data simpanan
            $simpanan->update([
                'jumlah' => $request->jumlah,
                'jenis_simpanan' => $request->jenis_simpanan,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan
            ]);

            DB::commit();
            return redirect()->route('admin.setoran.index')->with('success', 'Data setoran berhasil diperbarui');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            DB::beginTransaction();
            
            $simpanan = Simpanan::findOrFail($id);
            $simpanan->delete();

            DB::commit();
            return redirect()->route('admin.setoran.index')->with('success', 'Data setoran berhasil dihapus');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function create()
    {
        $users = \App\Models\User::where('role', 'member')->select('id', 'nama')->get();
        return view('admin.setoran.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'jumlah' => 'required|numeric|min:0',
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'tanggal' => 'required|date',
            'keterangan' => 'nullable|string'
        ]);

        try {
            DB::beginTransaction();
            
            Simpanan::create([
                'user_id' => $request->user_id,
                'jumlah' => $request->jumlah,
                'jenis_simpanan' => $request->jenis_simpanan,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan
            ]);

            DB::commit();
            return redirect()->route('admin.setoran.index')->with('success', 'Data setoran berhasil ditambahkan');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
} 