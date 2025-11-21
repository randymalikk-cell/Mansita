<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jenis',
        'jumlah',
        'keterangan',
        'pelanggan_id',
    ];

    // Relasi: Setiap Transaksi berkaitan dengan satu Pelanggan (N:1) 
    public function pelanggan(): BelongsTo
    {
        return $this->belongsTo(Pelanggan::class);
    }
}