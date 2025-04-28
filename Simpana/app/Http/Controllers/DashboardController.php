<?php

namespace App\Http\Controllers;

use App\Models\Simpanan;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Hitung total simpanan
        $totalSimpananPokok = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'pokok')
            ->where('status', 'approved')
            ->sum('jumlah');
            
        $totalSimpananWajib = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'wajib')
            ->where('status', 'approved')
            ->sum('jumlah');
            
        $totalSimpananSukarela = Simpanan::where('user_id', $user->id)
            ->where('jenis_simpanan', 'sukarela')
            ->where('status', 'approved')
            ->sum('jumlah');

        // Ambil transaksi terbaru
        $transaksiTerbaru = Transaksi::where('user_id', $user->id)
            ->with('simpanan')
            ->latest()
            ->take(5)
            ->get();

        return view('layouts.dashboard', compact(
            'user',
            'totalSimpananPokok',
            'totalSimpananWajib',
            'totalSimpananSukarela',
            'transaksiTerbaru'
        ));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('dashboard.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        
        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
        ]);

        $user->update([
            'nama' => $request->nama,
            'email' => $request->email,
            'no_telp' => $request->no_telp,
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('dashboard.profile')
            ->with('success', 'Profil berhasil diperbarui');
    }

    public function transactions()
    {
        $user = Auth::user();
        $transactions = Transaksi::where('user_id', $user->id)
            ->with('simpanan')
            ->latest()
            ->paginate(10);

        return view('dashboard.transactions', compact('user', 'transactions'));
    }

    public function simpanan()
    {
        $user = Auth::user();
        $simpanan = Simpanan::where('user_id', $user->id)
            ->latest()
            ->paginate(10);

        return view('dashboard.simpanan', compact('user', 'simpanan'));
    }

    public function createSimpanan()
    {
        $user = Auth::user();
        return view('dashboard.create-simpanan', compact('user'));
    }

    public function storeSimpanan(Request $request)
    {
        $request->validate([
            'jenis_simpanan' => 'required|in:pokok,wajib,sukarela',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:255',
        ]);

        Simpanan::create([
            'user_id' => Auth::id(),
            'jenis_simpanan' => $request->jenis_simpanan,
            'jumlah' => $request->jumlah,
            'tanggal' => now(),
            'status' => 'pending',
            'keterangan' => $request->keterangan,
        ]);

        return redirect()->route('dashboard.simpanan')
            ->with('success', 'Setoran simpanan berhasil diajukan');
    }

    // Method untuk Teller
    public function approveSimpanan(Request $request, Simpanan $simpanan)
    {
        if (Auth::user()->role !== 'teller') {
            return redirect()->back()->with('error', 'Anda tidak memiliki akses');
        }

        $request->validate([
            'status' => 'required|in:approved,rejected',
            'keterangan' => 'nullable|string|max:255',
        ]);

        $simpanan->update([
            'status' => $request->status,
            'keterangan' => $request->keterangan,
        ]);

        if ($request->status === 'approved') {
            Transaksi::create([
                'user_id' => $simpanan->user_id,
                'simpanan_id' => $simpanan->id,
                'jenis_transaksi' => 'setor',
                'jumlah' => $simpanan->jumlah,
                'tanggal' => now(),
                'status' => 'approved',
                'keterangan' => 'Setoran simpanan ' . $simpanan->jenis_simpanan,
            ]);
        }

        return redirect()->back()->with('success', 'Status simpanan berhasil diperbarui');
    }
} 