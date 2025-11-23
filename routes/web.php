<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
// Import Controller Autentikasi yang sesuai dengan file yang Anda miliki (Breeze Controllers)
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\RegisteredUserController;
// Anda juga memiliki Controller untuk fitur Lupa Password, Konfirmasi Password, dan Verifikasi Email
// yang bisa ditambahkan rutenya jika diperlukan.


// Import Controller yang berada di direktori App\Http\Controllers\Admin
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PelangganController;
use App\Http\Controllers\Admin\TransaksiController;
use App\Http\Controllers\Admin\StokController;
use App\Http\Controllers\Admin\LaporanController;
use App\Http\Controllers\Admin\BackupController;
use App\Http\Controllers\Admin\LogAktivitasController;
// Import Controller Staf Produksi
use App\Http\Controllers\StafProduksi\ProduksiController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Route ini dilindungi oleh middleware 'web' default Laravel.
| Gunakan alias 'role' untuk otorisasi akses berdasarkan peran.
|
*/

// =========================================================================
// ROUTE AUTENTIKASI (MENGGUNAKAN CONTROLLER BREEZE YANG DISEDIAKAN)
// Perbaikan: Menggunakan Controller yang benar: AuthenticatedSessionController & RegisteredUserController.
// =========================================================================

// Route Login
// Menampilkan form login: menggunakan AuthenticatedSessionController@create
Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
// Menangani proses login: menggunakan AuthenticatedSessionController@store
Route::post('/login', [AuthenticatedSessionController::class, 'store']);

// Route Register 
// Menampilkan form register: menggunakan RegisteredUserController@create
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
// Menangani proses register: menggunakan RegisteredUserController@store
Route::post('/register', [RegisteredUserController::class, 'store']);

// Route Logout
// Menghapus sesi: menggunakan AuthenticatedSessionController@destroy
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');


// =========================================================================
// 1. ROUTE UMUM (Semua User Terautentikasi)
// =========================================================================

Route::middleware(['auth'])->group(function () {
    // Route Landing Page (Direct ke Dashboard setelah login)
    Route::redirect('/', '/dashboard');

    // Route Dashboard Utama (Use Case 1)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Route Profil (Asumsi standar Laravel, bisa diakses semua role)
    // Jika ada controller kustom: Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
});

// =========================================================================
// 2. ROUTE STAF PRODUKSI (Role: staf produksi)
// Fungsi: Menginput Data Produksi (Use Case 2)
// =========================================================================

Route::middleware(['auth', 'role:staf produksi'])->prefix('staf-produksi')->name('staf-produksi.')->group(function () {
    
    // Produksi (Staf hanya perlu melihat daftar dan menambah data)
    Route::resource('produksi', ProduksiController::class)->only(['index', 'create', 'store']);
    
    // Jika dibutuhkan: Staf bisa melihat detail Produksi yang ia buat
    // Route::resource('produksi', ProduksiController::class)->only(['show']); 
});

// =========================================================================
// 3. ROUTE MANAJEMEN (Role: admin, pengurus)
// Fungsi: Stok, Transaksi, Laporan (Operasional & Pengawasan)
// =========================================================================

Route::middleware(['auth', 'role:admin,pengurus'])->prefix('manajemen')->name('manajemen.')->group(function () {
    
    // --- Pengelolaan Stok (Use Case 3) ---
    // Menampilkan ringkasan stok.
    Route::get('/stok', [StokController::class, 'index'])->name('stok.index');
    // Fungsi untuk penyesuaian/koreksi stok manual.
    Route::post('/stok/adjust', [StokController::class, 'adjust'])->name('stok.adjust');

    // --- Pengelolaan Transaksi ---
    // CRUD Transaksi (Penjualan, Pemasukan, Pengeluaran)
    Route::resource('transaksi', TransaksiController::class)->except(['show']);
    
    // --- Laporan (Use Case 5) ---
    Route::prefix('laporan')->name('laporan.')->group(function () {
        Route::get('/', [LaporanController::class, 'index'])->name('index'); // Daftar laporan
        Route::get('/buat', [LaporanController::class, 'create'])->name('create'); // Form parameter laporan
        Route::post('/generate', [LaporanController::class, 'generate'])->name('generate'); // Proses dan ekspor
    });
});

// =========================================================================
// 4. ROUTE ADMINISTRATOR (Role: admin)
// Fungsi: Master Data, Pengaturan Sistem, Audit Log
// =========================================================================

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // --- Pengelolaan Akun Pengguna (Use Case 6) ---
    // CRUD User
    Route::resource('users', UserController::class);

    // --- Pengelolaan Data Pelanggan (Use Case 4) ---
    // CRUD Pelanggan
    Route::resource('pelanggan', PelangganController::class);

    // --- Log Aktivitas (Audit Log) ---
    Route::get('log-aktivitas', [LogAktivitasController::class, 'index'])->name('log_aktivitas.index');
    
    // --- Backup & Restore (Use Case 7) ---
    Route::prefix('backup')->name('backup.')->group(function () {
        Route::get('/', [BackupController::class, 'index'])->name('index');      // Daftar riwayat backup
        Route::post('/execute', [BackupController::class, 'executeBackup'])->name('execute'); // Trigger Backup
        Route::post('/restore', [BackupController::class, 'executeRestore'])->name('restore'); // Trigger Restore
    });
});