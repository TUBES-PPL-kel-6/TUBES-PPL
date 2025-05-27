<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shu extends Model
{
    protected $fillable = [
        'tahun',
        'user_id',
        'jumlah_shu',
        'total_simpanan',
        'total_pinjaman',
        'kontribusi_simpanan',
        'kontribusi_pinjaman',
        'tanggal_generate'
    ];

    protected $casts = [
        'tanggal_generate' => 'datetime',
        'jumlah_shu' => 'decimal:2',
        'total_simpanan' => 'decimal:2',
        'total_pinjaman' => 'decimal:2',
        'kontribusi_simpanan' => 'decimal:2',
        'kontribusi_pinjaman' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }
}
