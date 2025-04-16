<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    public function dashboard()
    {
        $totalUsers = User::where('role', 'member')->count();
        $recentUsers = User::where('role', 'member')
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        return view('admin.index', compact('totalUsers', 'recentUsers'));
    }

    public function users()
    {
        $users = User::where('role', 'member')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('admin.index', compact('index'));
    }

    public function profile()
    {
        $admin = Auth::user();
        return view('admin.index', compact('index'));
    }
} 