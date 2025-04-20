<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        // Cek apakah admin sudah ada
        if (!User::where('email', 'admin@simpana.com')->exists()) {
            User::create([
                'email' => 'admin@simpana.com',
                'password' => Hash::make('admin123'), // Password default
                'nama' => 'Administrator',
                'alamat' => 'Kantor Pusat',
                'no_telp' => '081234567890',
                'nik' => '1234567890123456',
                'ktp' => 'admin_ktp.jpg',
                'role' => 'admin'
            ]);
            $this->command->info('Admin user created successfully!');
        } else {
            $this->command->info('Admin user already exists!');
        }
    }
} 