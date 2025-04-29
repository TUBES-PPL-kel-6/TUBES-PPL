<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setoran extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_anggota', 'jumlah_setoran', 'tanggal_setor', 'keterangan'
    ];
}
