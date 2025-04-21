<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AcceptanceController extends Controller
{

    public function index()
    {
        $pendingUsers  = User::where('status', 'pending')->get();
        $acceptedUsers = User::where('status', 'approved')->get();
        $rejectedUsers = User::where('status', 'rejected')->get();

        return view('acceptance', compact('pendingUsers', 'acceptedUsers', 'rejectedUsers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'approved';
        $user->save();

        return redirect()->route('acceptance.index')->with('success', 'Pengguna disetujui!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'rejected';
        $user->save();

        return redirect()->route('acceptance.index')->with('error', 'Pengguna ditolak!');
    }
}
