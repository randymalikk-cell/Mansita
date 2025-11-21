<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pelanggan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_pelanggan',
        'alamat',
        'kontak',
        'jadwal_pengiriman',
    ];

    // Relasi: Setiap Pelanggan dapat memiliki banyak Transaksi (1:N) 
    public function transaksis(): HasMany
    {
        return $this->hasMany(Transaksi::class);
    }
}