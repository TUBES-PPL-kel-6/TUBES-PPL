<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'simpanan_id',
        'jenis_transaksi', // setoran, penarikan
        'jumlah',
        'tanggal',
        'status', // pending, approved, rejected
        'keterangan',
        'approved_by' // id teller yang menyetujui
    ];

    protected $casts = [
        'tanggal' => 'date',
        'jumlah' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function simpanan()
    {
        return $this->belongsTo(Simpanan::class);
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
} 