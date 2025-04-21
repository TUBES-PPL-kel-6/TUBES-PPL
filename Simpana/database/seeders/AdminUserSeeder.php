<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'email' => 'admin@simpana.com',
            'password' => Hash::make('admin123'),
            'nama' => 'Admin Simpana',
            'alamat' => 'Jl. Admin No. 1, Jakarta',
            'no_telp' => '081234567890',
            'nik' => '1234567890123456',
            'ktp' => 'ktp_files/admin.jpg',
            'role' => 'admin',
            'has_paid' => true,
        ]);
    }
}
