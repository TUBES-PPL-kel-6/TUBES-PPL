<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
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
        // Validasi
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|confirmed',  // This expects password_confirmation field
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|numeric',
            'nik' => 'required|digits:16|numeric|unique:users,nik',
            'ktp' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048'
        ]);

        // Upload file KTP
        $ktpPath = $request->file('ktp')->store('ktp_files', 'public');

        // Simpan ke database
        $user = User::create([
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
            'nik' => $request->nik,
            'ktp' => $ktpPath,
            'role' => 'user',
        ]);

        Auth::login($user);

        return redirect()->route('payment.show')->with('success', 'Registration successful!');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Coba autentikasi user
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            
            // Check user role and redirect accordingly
            if (Auth::user()->role === 'admin') {
                return redirect()->route('admin.index');
            }
            
            // Default redirect for regular users
            return redirect()->route('user.dashboard')
                ->with('success', 'Login berhasil!');
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->withInput();
    }

    public function showPaymentPage()
    {
        $user = Auth::user(); // Get the authenticated user
        return view('payment', compact('user')); // Pass the user to the payment view
    }

}
