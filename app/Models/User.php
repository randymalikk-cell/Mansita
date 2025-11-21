<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'username',
        'email',
        'password',
        'nama',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relasi: Setiap User dapat melakukan banyak Produksi (1:N) 
    public function produksis(): HasMany
    {
        return $this->hasMany(Produksi::class);
    }

    // Relasi: Setiap User dapat membuat banyak Laporan (1:N) 
    public function laporans(): HasMany
    {
        return $this->hasMany(Laporan::class, 'dibuat_oleh_user_id');
    }

    // Relasi: Setiap User dapat membuat banyak Backup (1:N) 
    public function backups(): HasMany
    {
        return $this->hasMany(Backup::class, 'dibuat_oleh_user_id');
    }

    // Relasi: User memiliki banyak Log Aktivitas
    public function logAktivitas(): HasMany
    {
        return $this->hasMany(LogAktivitas::class);
    }
}
