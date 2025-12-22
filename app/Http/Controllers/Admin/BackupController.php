<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Backup;
use App\Models\Produksi;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
use Exception;

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
        return view('admin.backup.index', compact('backups'));
    }

    /**
     * Menjalankan proses backup data secara manual.
     */
    public function executeBackup()
    {
        try {
            // Generate nama file backup dengan timestamp
            $timestamp = now()->format('Y-m-d_H-i-s');
            $filename = "backup_{$timestamp}.json";
            $filepath = "backups/{$filename}";

            // Kumpulkan semua data sistem (dari dashboard)
            $backupData = [
                'timestamp' => $timestamp,
                'pelanggan' => Pelanggan::all(),
                'produksi' => Produksi::all(),
                'stok' => Stok::all(),
                'transaksi' => Transaksi::all(),
                'log_aktivitas' => LogAktivitas::latest()->limit(100)->get(),
            ];

            // Simpan ke file JSON di storage
            Storage::disk('local')->put($filepath, json_encode($backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            // Catat ke database
            Backup::create([
                'tanggal' => now(),
                'jenis' => 'manual',
                'file_backup' => $filename,
                'dibuat_oleh_user_id' => auth()->id(),
            ]);

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Menjalankan proses backup data sistem secara manual. File: ' . $filename
            ]);

            return back()->with('success', "Proses backup berhasil dilaksanakan. File: {$filename}");

        } catch (Exception $e) {
            return back()->with('error', 'Backup gagal: ' . $e->getMessage());
        }
    }

    /**
     * Menjalankan proses restore data (Fungsionalitas sensitif, perlu konfirmasi).
     */
    public function executeRestore(Request $request)
    {
        try {
            // Jika ada backup_id, restore dari backup spesifik; jika tidak, gunakan terbaru
            $backupId = $request->input('backup_id');
            
            if ($backupId) {
                $backup = Backup::findOrFail($backupId);
            } else {
                $backup = Backup::latest()->first();
            }

            if (!$backup) {
                return back()->with('error', 'Tidak ada file backup yang tersedia untuk restore.');
            }

            $filepath = "backups/{$backup->file_backup}";

            if (!Storage::disk('local')->exists($filepath)) {
                return back()->with('error', 'File backup tidak ditemukan di penyimpanan.');
            }

            // Baca file backup
            $backupJson = Storage::disk('local')->get($filepath);
            $backupData = json_decode($backupJson, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                return back()->with('error', 'File backup rusak atau tidak valid.');
            }

            // Mulai transaksi database
            DB::beginTransaction();

            try {
                // Disable foreign key checks untuk truncate
                DB::statement('SET FOREIGN_KEY_CHECKS=0');

                // Truncate tabel dalam urutan yang benar (child tables dulu)
                DB::table('stoks')->truncate();
                DB::table('transaksis')->truncate();
                DB::table('produksis')->truncate();
                DB::table('pelanggans')->truncate();

                // Insert data dari backup menggunakan insert (preserves IDs)
                if (!empty($backupData['pelanggans'])) {
                    foreach ($backupData['pelanggans'] as $record) {
                        DB::table('pelanggans')->insert((array) $record);
                    }
                }

                if (!empty($backupData['produksi'])) {
                    foreach ($backupData['produksi'] as $record) {
                        DB::table('produksis')->insert((array) $record);
                    }
                }

                if (!empty($backupData['stok'])) {
                    foreach ($backupData['stok'] as $record) {
                        DB::table('stoks')->insert((array) $record);
                    }
                }

                if (!empty($backupData['transaksi'])) {
                    foreach ($backupData['transaksi'] as $record) {
                        DB::table('transaksis')->insert((array) $record);
                    }
                }

                // Re-enable foreign key checks
                DB::statement('SET FOREIGN_KEY_CHECKS=1');

                DB::commit();

                // Log aktivitas restore
                LogAktivitas::create([
                    'user_id' => auth()->id(),
                    'aktivitas' => 'Melakukan proses restore data dari file: ' . $backup->file_backup
                ]);

                return back()->with('success', 'Proses restore data berhasil dilaksanakan dari: ' . $backup->file_backup);

            } catch (Exception $e) {
                DB::rollBack();
                throw $e;
            }

        } catch (Exception $e) {
            return back()->with('error', 'Restore gagal: ' . $e->getMessage());
        }
    }

    /**
     * Download file backup
     */
    public function download($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $filepath = "backups/{$backup->file_backup}";

            if (!Storage::disk('local')->exists($filepath)) {
                return back()->with('error', 'File backup tidak ditemukan.');
            }

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Mendownload file backup: ' . $backup->file_backup
            ]);

            return Storage::disk('local')->download($filepath);

        } catch (Exception $e) {
            return back()->with('error', 'Download gagal: ' . $e->getMessage());
        }
    }

    /**
     * Delete backup file
     */
    public function delete($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $filepath = "backups/{$backup->file_backup}";

            // Hapus file dari storage
            if (Storage::disk('local')->exists($filepath)) {
                Storage::disk('local')->delete($filepath);
            }

            // Hapus record dari database
            $backup->delete();

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Menghapus file backup: ' . $backup->file_backup
            ]);

            return back()->with('success', 'File backup berhasil dihapus.');

        } catch (Exception $e) {
            return back()->with('error', 'Hapus gagal: ' . $e->getMessage());
        }
    }
}