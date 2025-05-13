<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }

    public function riwayat()
    {
        return view('dashboard.riwayat');
    }

    public function setor()
    {
        return view('dashboard.setor');
    }

    public function pinjaman()
    {
        return view('dashboard.pinjaman');
    }

    public function profil()
    {
        $users = User::all(); // contoh ambil data user
        return view('dashboard.profil', compact('users'));
    }

    public function pengaturan()
    {
        return view('dashboard.pengaturan');
    }
}

