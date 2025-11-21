<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Produksi extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'shift',
        'jumlah_tahu_putih',
        'jumlah_tahu_kuning',
        'user_id',
    ];

    // Relasi: Setiap Produksi dibuat oleh satu User (N:1)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi: Setiap Produksi menghasilkan satu data Stok (1:1) 
    public function stok(): HasOne
    {
        return $this->hasOne(Stok::class);
    }
}
