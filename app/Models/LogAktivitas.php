<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LogAktivitas extends Model
{
    use HasFactory;
    
    // Sesuaikan nama tabel jika perlu, asumsikan snake_case: log_aktivitas
    protected $table = 'log_aktivitas';

    protected $fillable = [
        'user_id',
        'aktivitas',
    ];

    // Relasi: Log Aktivitas dimiliki oleh satu User (N:1)
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}