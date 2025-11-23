<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use Illuminate\Http\Request;
use Artisan; // Untuk menjalankan perintah Artisan dari Controller

// Asumsi menggunakan package Spatie/laravel-backup (sesuai SDD)

class BackupController extends Controller
{
    // Otorisasi: Hanya Admin yang dapat mengakses (Use Case 7)
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'admin') {
                abort(403, 'Akses hanya untuk Administrator.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar backup yang tersedia.
     */
    public function index()
    {
        $backups = Backup::latest()->paginate(10);
        // Anda juga bisa memanggil Spatie Backup API untuk daftar file di storage
        return view('admin.backup.index', compact('backups'));
    }

    /**
     * Menjalankan proses backup data secara manual.
     */
    public function executeBackup()
    {
        try {
            // Menjalankan perintah Spatie Backup
            Artisan::call('backup:run', ['--only-db' => true]);

            // Catat ke database
            Backup::create([
                'tanggal' => now(),
                'jenis' => 'manual',
                'file_backup' => 'latest_backup_db', // Placeholder
                'dibuat_oleh_user_id' => auth()->id(),
            ]);

            \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Menjalankan proses backup database secara manual.']);
            
            return back()->with('success', 'Proses backup berhasil dilaksanakan.');

        } catch (\Exception $e) {
            return back()->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    /**
     * Menjalankan proses restore data (Fungsionalitas sensitif, perlu konfirmasi).
     */
    public function executeRestore(Request $request)
    {
        // Peringatan: Restore adalah proses yang sangat berbahaya
        // Biasanya memerlukan otentikasi ulang atau konfirmasi khusus.
        // Asumsi restore menggunakan file backup terbaru
        try {
            // Contoh perintah restore Spatie (jika di-customize) atau logika restore manual
            // Artisan::call('backup:restore', ['--filename' => $request->filename]); 
            
            \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Menjalankan proses restore database.']);

            return back()->with('warning', 'Fungsionalitas restore telah dipanggil. Perlu implementasi logika restore yang aman.');

        } catch (\Exception $e) {
            return back()->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }
}