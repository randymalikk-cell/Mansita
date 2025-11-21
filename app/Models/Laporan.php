<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Laporan extends Model
{
    use HasFactory;

    protected $fillable = [
        'jenis',
        'tanggal',
        'keterangan',
        'format',
        'dibuat_oleh_user_id',
    ];

    // Relasi: Laporan dibuat oleh satu User (N:1)
    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
    }
}