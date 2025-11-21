<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Backup extends Model
{
    use HasFactory;

    protected $fillable = [
        'tanggal',
        'jenis',
        'file_backup',
        'dibuat_oleh_user_id',
    ];

    // Relasi: Backup dibuat oleh satu User (N:1)
    public function dibuatOleh(): BelongsTo
    {
        return $this->belongsTo(User::class, 'dibuat_oleh_user_id');
    }
}