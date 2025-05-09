<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('nama');
            $table->text('alamat');
            $table->string('no_telp');
            $table->string('nik', 16)->unique();
            $table->string('ktp'); // path file KTP
            $table->string('status')->default('pending'); // ← Tambahkan ini
            $table->rememberToken();
            $table->timestamps();
        });
        
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
}; 