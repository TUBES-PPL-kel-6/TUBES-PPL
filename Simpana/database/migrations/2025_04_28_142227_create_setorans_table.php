<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSetoransTable extends Migration
{
    public function up()
    {
        Schema::create('setorans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_anggota');
            $table->decimal('jumlah_setoran', 15, 2);
            $table->date('tanggal_setor')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('setorans');
    }
}
