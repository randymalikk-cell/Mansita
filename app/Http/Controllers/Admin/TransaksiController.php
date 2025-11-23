<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    // Otorisasi: Admin dan Pengurus dapat mengakses
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
     * Menampilkan daftar transaksi.
     */
    public function index()
    {
        $transaksis = Transaksi::with('pelanggan')->latest()->paginate(10);
        return view('admin.transaksis.index', compact('transaksis'));
    }

    /**
     * Menampilkan form pembuatan transaksi baru.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('admin.transaksis.create', compact('pelanggans'));
    }

    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:penjualan,pemasukan,pengeluaran', // Menambahkan pengeluaran
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'pelanggan_id' => 'required_if:jenis,penjualan|nullable|exists:pelanggans,id',
        ]);

        Transaksi::create($validated);
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Mencatat transaksi jenis: ' . $validated['jenis'] . ' sebesar ' . $validated['jumlah']]);

        return redirect()->route('admin.transaksis.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    // ... method edit, update, destroy (standar CRUD)
    // Disederhanakan untuk contoh
}