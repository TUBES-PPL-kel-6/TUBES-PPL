<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Simpanan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'jenis_simpanan', // pokok, wajib, sukarela
        'jumlah',
        'tanggal',
        'keterangan',
        'status', // <-- pastikan ada!
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
