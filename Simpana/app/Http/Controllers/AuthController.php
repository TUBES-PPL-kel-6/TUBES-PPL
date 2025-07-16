<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = \App\Models\User::where('email', $request->email)->first();
        
        if (!$user) {
            return back()->withErrors([
                'email' => 'Email tidak ditemukan.'
            ])->withInput($request->only('email'));
        }

        // Check if user is admin
        if ($user->role === 'admin') {
            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();
                return redirect()->route('admin.index');
            }
        } else {
            // For regular users, check status
            if ($user->status === 'rejected') {
                return back()->withErrors([
                    'email' => 'Akun Anda telah ditolak.'
                ])->withInput($request->only('email'));
            }
            
            if ($user->status === 'pending') {
                return back()->withErrors([
                    'email' => 'Akun Anda masih dalam proses persetujuan. Silakan tunggu hingga akun disetujui.'
                ])->withInput($request->only('email'));
            }

            if (Auth::attempt($request->only('email', 'password'))) {
                $request->session()->regenerate();
                return redirect()->route('user.dashboard');
            }
        }

        return back()->withErrors([
            'email' => 'Email atau password salah.'
        ])->withInput($request->only('email'));
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
