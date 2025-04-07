<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegistController extends Controller
{
    public function showForm()
    {
        return view('register');
    }

    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|numeric',
            'nik' => 'required|digits:16|numeric|unique:users,nik',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Upload file KTP
        $ktpPath = $request->file('ktp')->store('ktp_files', 'public');

        // Simpan ke database
        User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'nik' => $request->nik,
            'ktp' => $ktpPath
        ]);

        return redirect('/')->with('success', 'Pendaftaran berhasil!');
    }
}
