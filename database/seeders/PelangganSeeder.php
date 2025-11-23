<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pelanggan;

class PelangganSeeder extends Seeder
{
    /**
     * Menjalankan seeds database untuk membuat data pelanggan awal.
     */
    public function run(): void
    {
        Pelanggan::create([
            'nama_pelanggan' => 'Pasar Induk Bandung',
            'alamat' => 'Jl. Cibaduyut No. 10, Bandung',
            'kontak' => '0812-3456-7890',
            'jadwal_pengiriman' => 'Setiap Hari Pagi',
        ]);

        Pelanggan::create([
            'nama_pelanggan' => 'Toko Sembako Jaya',
            'alamat' => 'Jl. Sudirman No. 25, Cimahi',
            'kontak' => '0877-6543-2109',
            'jadwal_pengiriman' => 'Setiap Rabu dan Sabtu',
        ]);
    }
}