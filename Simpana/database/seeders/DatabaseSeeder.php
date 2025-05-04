<?php

namespace Database\Seeders;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call the AdminUserSeeder
        $this->call(AdminSeeder::class);

        // Create a test user with the correct field names
        User::create([
            'email' => 'test@example.com',
            'password' => Hash::make('password'),
            'nama' => 'Test User',
            'alamat' => 'Jl. Test No. 123',
            'no_telp' => '08123456789',
            'nik' => '9876543210123456',
            'ktp' => 'ktp_files/test.jpg',
            'role' => 'user',
            'has_paid' => true,
        ]);
    }
}
