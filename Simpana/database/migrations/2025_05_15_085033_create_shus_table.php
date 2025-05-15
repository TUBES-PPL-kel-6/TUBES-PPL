<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shus', function (Blueprint $table) {
            $table->id();
            $table->year('tahun');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('jumlah_shu', 12, 2);
            $table->decimal('total_simpanan', 12, 2);
            $table->decimal('total_pinjaman', 12, 2);
            $table->decimal('kontribusi_simpanan', 12, 2);
            $table->decimal('kontribusi_pinjaman', 12, 2);
            $table->timestamp('tanggal_generate');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shus');
    }
};
