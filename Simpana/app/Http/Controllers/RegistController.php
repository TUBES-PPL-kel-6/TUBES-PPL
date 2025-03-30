<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RegistController extends Controller
{
    public function showForm()
    {
        return view('register');
    }

    public function submitForm(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
            'nama' => 'required',
            'alamat' => 'required',
            'no_telp' => 'required|numeric',
            'nik' => 'required|numeric|digits:16',
            'ktp' => 'required|file|mimes:jpg,png,pdf|max:2048'
        ]);

        // Simpan atau proses data (tanpa database)
        return redirect()->back()->with('success', 'Pendaftaran berhasil!');
    }
}
