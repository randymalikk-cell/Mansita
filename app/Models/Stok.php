<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Stok extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal_update',
        'total_tahu_putih',
        'total_tahu_kuning',
        'produksi_id',
    ];

    // Relasi: Setiap Stok dihasilkan dari satu Produksi (1:1)
    public function produksi(): BelongsTo
    {
        return $this->belongsTo(Produksi::class);
    }
}
