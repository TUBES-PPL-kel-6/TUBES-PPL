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
        try {
            $user = User::findOrFail($id);
            $user->status = 'approved';
            $user->save();

            return redirect()->route('acceptance.index')
                ->with('success', $user->nama . ' telah DITERIMA');
        } catch (\Exception $e) {
            return redirect()->route('acceptance.index')
                ->with('error', 'Gagal mengubah status anggota. Silakan coba lagi.');
        }
    }

    public function reject($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->status = 'rejected';
            $user->save();

            return redirect()->route('acceptance.index')
                ->with('error', $user->nama . ' telah DITOLAK');
        } catch (\Exception $e) {
            return redirect()->route('acceptance.index')
                ->with('error', 'Gagal mengubah status anggota. Silakan coba lagi.');
        }
    }
}
