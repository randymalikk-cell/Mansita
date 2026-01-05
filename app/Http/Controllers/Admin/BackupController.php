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
            $filepath = "private/backups/{$filename}";

            // Kumpulkan semua data sistem (dari dashboard)
            $backupData = [
                'timestamp' => $timestamp,
                'pelanggan' => Pelanggan::all(),
                'produksis' => Produksi::all(),
                'stoks' => Stok::all(),
                'transaksis' => Transaksi::all(),
                'log_aktivitas' => LogAktivitas::latest()->limit(100)->get(),
            ];

            // Simpan ke file JSON di storage
            Storage::disk('local')->put(
                $filepath,
                json_encode($backupData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
            );

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
    public function executeRestore($id)
    {
        $backup = Backup::findOrFail($id);
        $path = 'private/backups/' . $backup->file_backup;

        if (!Storage::disk('local')->exists($path)) {
            return back()->with('error', 'File backup tidak ditemukan.');
        }

        $data = json_decode(Storage::disk('local')->get($path), true);

        if (!$data) {
            return back()->with('error', 'File backup rusak atau tidak valid.');
        }

        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        try {
            DB::beginTransaction();

            // ❗ GUNAKAN DELETE, BUKAN TRUNCATE
            DB::table('transaksis')->delete();
            DB::table('stoks')->delete();
            DB::table('produksis')->delete();
            DB::table('pelanggans')->delete();
            DB::table('log_aktivitas')->delete();

            $fixDate = fn ($v) =>
                $v ? Carbon::parse($v)->format('Y-m-d H:i:s') : null;

            foreach ($data['pelanggan'] ?? [] as $row) {
                DB::table('pelanggans')->insert([
                    'id' => $row['id'],
                    'nama_pelanggan' => $row['nama_pelanggan'],
                    'alamat' => $row['alamat'],
                    'kontak' => $row['kontak'],
                    'jadwal_pengiriman' => $row['jadwal_pengiriman'],
                    'created_at' => $this->normalizeDatetime($row['created_at']),
                    'updated_at' => $this->normalizeDatetime($row['updated_at']),
                ]);
            }

            foreach ($data['produksis'] ?? [] as $row) {
                DB::table('produksis')->insert([
                    'id' => $row['id'],
                    'tanggal' => $row['tanggal'],
                    'shift' => $row['shift'],
                    'jumlah_tahu_putih' => $row['jumlah_tahu_putih'],
                    'jumlah_tahu_kuning' => $row['jumlah_tahu_kuning'],
                    'user_id' => $row['user_id'],
                    'created_at' => $this->normalizeDatetime($row['created_at']),
                    'updated_at' => $this->normalizeDatetime($row['updated_at']),
                ]);
            }

            foreach ($data['stoks'] ?? [] as $row) {
                DB::table('stoks')->insert([
                    'id' => $row['id'],
                    'tanggal_update' => $row['tanggal_update'],
                    'total_tahu_putih' => $row['total_tahu_putih'],
                    'total_tahu_kuning' => $row['total_tahu_kuning'],
                    'produksi_id' => $row['produksi_id'],
                    'created_at' => $this->normalizeDatetime($row['created_at']),
                    'updated_at' => $this->normalizeDatetime($row['updated_at']),
                ]);
            }

            foreach ($data['transaksis'] ?? [] as $row) {
                DB::table('transaksis')->insert([
                    'id' => $row['id'],
                    'tanggal' => $row['tanggal'],
                    'jenis' => $row['jenis'],
                    'jumlah' => $row['jumlah'],
                    'keterangan' => $row['keterangan'],
                    'pelanggan_id' => $row['pelanggan_id'],
                    'created_at' => $this->normalizeDatetime($row['created_at']),
                    'updated_at' => $this->normalizeDatetime($row['updated_at']),
                ]);
            }

            foreach ($data['log_aktivitas'] ?? [] as $row) {
                DB::table('log_aktivitas')->insert([
                    'id' => $row['id'],
                    'user_id' => $row['user_id'],
                    'aktivitas' => $row['aktivitas'],
                    'created_at' => $this->normalizeDatetime($row['created_at']),
                    'updated_at' => $this->normalizeDatetime($row['updated_at']),
                ]);
            }



            DB::commit();

            LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Melakukan restore database dari file: ' . $backup->file_backup
            ]);

            return back()->with('success', 'Restore database berhasil.');

        } catch (\Throwable $e) {

            if (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            return back()->with('error', 'Restore gagal: ' . $e->getMessage());

        } finally {
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }
    }


    /**
     * Download file backup
     */
    public function download($id)
    {
        try {
            $backup = Backup::findOrFail($id);
            $filepath = "private/backups/{$backup->file_backup}";

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
            $filepath = "private/backups/{$backup->file_backup}";

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
    private function normalizeDatetime($value)
    {
        if (!$value) return null;

        try {
            return \Carbon\Carbon::parse($value)
                ->setTimezone(config('app.timezone'))
                ->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return null;
        }
    }


    public function restore(Request $request)
    {
        $request->validate([
            'backup' => 'required|file|mimes:json'
        ]);

        $file = $request->file('backup');

        if (!$file->isValid()) {
            return back()->with('error', 'File backup tidak valid');
        }

        $data = json_decode(
            file_get_contents($file->getRealPath()),
            true
        );

        if (!$data) {
            return back()->with('error', 'File JSON rusak atau tidak bisa dibaca');
        }

        DB::transaction(function () use ($data) {
            // proses insert data di sini
        });

        return back()->with('success', 'Restore berhasil');
    }


}