<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'email' => 'admin@simpana.com',
            'password' => Hash::make('admin123'),
            'nama' => 'Administrator',
            'role' => 'admin',
            'status' => 'approved',
            'alamat' => 'Jl. Admin No. 1',
            'no_telp' => '08123456789',
            'nik' => '1234567890123456'
        ]);
    }
} 