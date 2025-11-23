<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Menjalankan seeds database untuk membuat user awal.
     * Kredensial standar untuk semua: username = [username], password = password
     */
    public function run(): void
    {
        // =================================================================
        // 1. AKUN ADMINISTRATOR (Role: admin)
        // Hak Akses Penuh: User, Pelanggan, Stok, Laporan, Backup (Use Case 3,4,5,6,7)
        // =================================================================
        User::create([
            'nama' => 'Administrator Utama',
            'username' => 'admin',
            'email' => 'admin@tahu.com',
            'role' => 'admin',
            'password' => Hash::make('password'), // Password: password
        ]);

        // =================================================================
        // 2. AKUN PENGURUS (Role: pengurus)
        // Hak Akses Menengah: Stok, Transaksi, Laporan (Use Case 3, 5)
        // =================================================================
        User::create([
            'nama' => 'Pengurus Operasional',
            'username' => 'pengurus',
            'email' => 'pengurus@tahu.com',
            'role' => 'pengurus',
            'password' => Hash::make('password'), // Password: password
        ]);

        // =================================================================
        // 3. AKUN STAF PRODUKSI (Role: staf produksi)
        // Hak Akses Terbatas: Input Produksi (Use Case 2)
        // =================================================================
        User::create([
            'nama' => 'Staf Produksi 01',
            'username' => 'staf01',
            'email' => 'staf01@tahu.com',
            'role' => 'staf produksi',
            'password' => Hash::make('password'), // Password: password
        ]);
        
        // Contoh Staf Produksi Tambahan
        User::create([
            'nama' => 'Staf Produksi 02',
            'username' => 'staf02',
            'email' => 'staf02@tahu.com',
            'role' => 'staf produksi',
            'password' => Hash::make('password'), // Password: password
        ]);
    }
}