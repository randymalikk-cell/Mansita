<?php

namespace App\Http\Controllers\StafProduksi;

use App\Http\Controllers\Controller;
use App\Models\Produksi;
use App\Models\Stok;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProduksiController extends Controller
{
    // Otorisasi: Hanya Staf Produksi yang dapat mengakses
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(function ($request, $next) {
            if (auth()->user()->role !== 'staf produksi') {
                abort(403, 'Akses hanya untuk Staf Produksi.');
            }
            return $next($request);
        });
    }

    /**
     * Menampilkan daftar produksi yang sudah diinput oleh staf tersebut.
     */
    public function index()
    {
        $produksis = Produksi::where('user_id', auth()->id())->latest()->paginate(10);
        return view('staf_produksi.produksi.index', compact('produksis'));
    }

    /**
     * Menampilkan form untuk input data produksi harian (Use Case 2).
     */
    public function create()
    {
        return view('staf_produksi.produksi.create');
    }

    /**
     * Menyimpan data produksi baru dan memperbarui stok.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'shift' => 'required|string|max:50',
            'jumlah_tahu_putih' => 'required|integer|min:0',
            'jumlah_tahu_kuning' => 'required|integer|min:0',
        ]);

        DB::beginTransaction();
        try {
            // 1. Simpan data Produksi
            $produksi = Produksi::create([
                'tanggal' => $validated['tanggal'],
                'shift' => $validated['shift'],
                'jumlah_tahu_putih' => $validated['jumlah_tahu_putih'],
                'jumlah_tahu_kuning' => $validated['jumlah_tahu_kuning'],
                'user_id' => auth()->id(),
            ]);

            // 2. Perbarui Stok Utama (asumsi ada satu baris master stok yang di-update)
            // Logika ini lebih akurat diletakkan di StokController atau Service,
            // namun untuk memenuhi requirement SDD, kita simpan Stok yang terelasi.
            Stok::create([
                'tanggal_update' => now(),
                'total_tahu_putih' => $validated['jumlah_tahu_putih'],
                'total_tahu_kuning' => $validated['jumlah_tahu_kuning'],
                'produksi_id' => $produksi->id,
            ]);

            // Tambahkan Log Aktivitas
            \App\Models\LogAktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Menginput data produksi tanggal ' . $produksi->tanggal,
            ]);

            DB::commit();
            return redirect()->route('staf-produksi.produksi.index')->with('success', 'Data produksi berhasil diinput dan stok telah dicatat.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan data produksi: ' . $e->getMessage());
        }
    }
}