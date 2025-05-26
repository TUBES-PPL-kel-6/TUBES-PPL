<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Simpanan; // Tambahkan di atas

class simpPokokController extends Controller
{
    public function show()
    {
        // Get the authenticated user and pass it to the view
        $user = Auth::user();
        return view('payment', compact('user'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();

        // Simpan ke tabel Simpanan
        Simpanan::create([
            'user_id'        => $user->id,
            'jenis_simpanan' => 'pokok', // atau sesuai kebutuhan
            'jumlah'         => 50000,   // nominal pembayaran, bisa dari request jika dinamis
            'tanggal'        => now(),
            'status'         => 'approved', // agar langsung masuk laporan
        ]);

        // Update status user
        $user->update([
            'has_paid' => true,
        ]);

        return redirect()->route('login')->with('success', 'Payment successful. You can now log in.');
    }
}
