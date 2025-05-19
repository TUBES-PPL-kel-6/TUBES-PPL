<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pinjaman extends Model
{
    use HasFactory;

    protected $table = 'pinjamans';

    protected $fillable = [
        'user_id',
        'jumlah_pinjaman',
        'jangka_waktu',
        'tanggal_pinjaman',
        'status',
        'keterangan'
    ];

    protected $casts = [
        'tanggal_pinjaman' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
} 