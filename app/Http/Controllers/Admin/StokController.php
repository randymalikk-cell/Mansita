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
            if (!in_array(auth('web')->user()->role, ['admin', 'pengurus'])) {
                abort(403, 'Akses hanya untuk Admin atau Pengurus.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan ringkasan stok saat ini.
     */
    public function index(Request $request)
    {
        $query = Stok::with('produksi')->latest('tanggal_update');
        
        // Hitung total stok (Logika Sederhana: Total dari semua stok yang tercatat)
        $totalPutih = Stok::sum('total_tahu_putih');
        $totalKuning = Stok::sum('total_tahu_kuning');
        $totalStok = $totalPutih + $totalKuning;

        if ($request->filled('search')) {
            $query->whereHas('produksi', function($q) use ($request) {
                $q->where('nama_produk', 'LIKE', "%{$request->search}%");
            });
        }

        $stoks = $query->paginate(10);
        return view('manajemen.stok.index', compact('stoks', 'totalPutih', 'totalStok', 'totalKuning'));
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
        
        \App\Models\LogAktivitas::create(['user_id' => auth('web')->id(), 'aktivitas' => 'Melakukan penyesuaian stok manual.']);

        return back()->with('success', 'Stok berhasil disesuaikan secara manual.');
    }

    /**
     * Menampilkan form untuk membuat stok baru.
     */
    public function create()
    {
        return view('manajemen.stok.create');
    }

    /**
     * Menyimpan stok baru ke database.
     */
    public function store(Request $request){
        $request->validate([
            'total_tahu_putih' => 'required|integer|min:0',
            'total_tahu_kuning' => 'required|integer|min:0',
        ]);

        // otomatis ambil produksi terakhir
        $produksi = \App\Models\Produksi::orderBy('id', 'desc')->first();

        Stok::create([
            'produksi_id' => $produksi ? $produksi->id : 0,
            'total_tahu_putih' => $request->total_tahu_putih,
            'total_tahu_kuning' => $request->total_tahu_kuning,
            'tanggal_update' => now(),
        ]);

        return redirect()->route('manajemen.stok.index')->with('success', 'Stok berhasil ditambahkan.');
    }


    /**
     * Menampilkan detail stok tertentu.
     */
    public function show(Stok $stok)
    {
        return view('manajemen.stok.show', compact('stok'));
    }

    /**
     * Menampilkan form untuk mengedit stok.
     */
    public function edit(Stok $stok)
    {
        return view('manajemen.stok.edit', compact('stok'));
    }

    /**
     * Memperbarui stok ke database.
     */
    public function update(Request $request, Stok $stok)
    {
        $request->validate([
            'total_tahu_putih' => 'required|integer|min:0',
            'total_tahu_kuning' => 'required|integer|min:0',
        ]);

        $stok->update([
            'total_tahu_putih' => $request->total_tahu_putih,
            'total_tahu_kuning' => $request->total_tahu_kuning,
            'tanggal_update' => now(),
        ]);

        \App\Models\LogAktivitas::create(['user_id' => auth('web')->id(), 'aktivitas' => 'Mengedit data stok.']);

        return redirect()->route('manajemen.stok.index')->with('success', 'Stok berhasil diperbarui.');
    }

    /**
     * Menghapus stok dari database.
     */
    public function destroy(Stok $stok)
    {
        $stok->delete();

        \App\Models\LogAktivitas::create(['user_id' => auth('web')->id(), 'aktivitas' => 'Menghapus data stok.']);

        return back()->with('success', 'Stok berhasil dihapus.');
    }
}