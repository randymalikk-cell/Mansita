<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StokController extends Controller
{
    // Otorisasi: Admin dan Pengurus dapat mengakses (Use Case 3)
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (!in_array(auth()->user()->role, ['admin', 'pengurus'])) {
                abort(403, 'Akses hanya untuk Admin atau Pengurus.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan ringkasan stok saat ini.
     * (Asumsi: Stok terakhir adalah total stok yang dihitung dari semua Produksi dan Transaksi)
     */
    public function index()
    {
        // Untuk implementasi skala besar, lebih baik menggunakan tabel master stok.
        // Untuk saat ini, kita tampilkan data stok dari setiap Produksi (sesuai Model)
        $stoks = Stok::with('produksi')->latest('tanggal_update')->paginate(10);
        
        // Hitung total stok (Logika Sederhana: Total dari semua stok yang tercatat)
        $totalPutih = Stok::sum('total_tahu_putih');
        $totalKuning = Stok::sum('total_tahu_kuning');

        return view('admin.stoks.index', compact('stoks', 'totalPutih', 'totalKuning'));
    }

    /**
     * Form untuk menyesuaikan total stok secara manual (koreksi).
     */
    public function adjust(Request $request)
    {
        // Ini adalah fungsionalitas esensial untuk koreksi manual
        $request->validate([
            'tahu_putih' => 'required|integer',
            'tahu_kuning' => 'required|integer',
            'keterangan' => 'nullable|string',
        ]);

        // Logika penyesuaian: update baris master stok terakhir (jika menggunakan 1 master row)
        // Atau buat entri Stok baru dengan Produksi ID=NULL (jika memungkinkan)
        // Untuk kepatuhan SDD, kita anggap ini memperbarui total saat ini.
        DB::table('stoks')->updateOrInsert(
            ['produksi_id' => null], // Identifier untuk baris master stok
            [
                'tanggal_update' => now(),
                'total_tahu_putih' => $request->tahu_putih,
                'total_tahu_kuning' => $request->tahu_kuning,
            ]
        );
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Melakukan penyesuaian stok manual.']);

        return back()->with('success', 'Stok berhasil disesuaikan secara manual.');
    }
}