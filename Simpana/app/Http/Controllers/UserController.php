<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentReminderMail;
use App\Models\Notification;

class UserController extends Controller
{
    public function dashboard()
    {
        $user = Auth::user();
        return view('user.dashboard', compact('user'));
    }

    public function profile()
    {
        $user = Auth::user();
        return view('user.profile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_telp' => 'required|numeric',
        ]);

        $user->update([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_telp' => $request->no_telp,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    public function listUsers()
    {
        $users = \App\Models\User::where('role', 'user')->get();
        return view('admin.list_users', compact('users'));
    }

    public function remindUser($id)
    {
        $user = User::findOrFail($id);

        Notification::create([
            'user_id' => $user->id,
            'type' => 'general',
            'message' => 'Selamat datang di aplikasi SIMPANA! Jangan lupa melakukan pembayaran simpanan/pinjaman Anda!',
        ]);

        return redirect()->route('admin.users')->with('success', 'Peringatan pembayaran berhasil dikirim ke ' . $user->name);
    }

    public function showNotifications()
    {
        $notifications = \App\Models\Notification::where('user_id', auth()->user()->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('notifications', compact('notifications'));
    }

    public function showGeneralNotifications()
    {
        $notifications = \App\Models\Notification::where('user_id', auth()->id())
            ->where('type', 'general')
            ->latest()
            ->get();
        return view('notifications', compact('notifications'));
    }
}
