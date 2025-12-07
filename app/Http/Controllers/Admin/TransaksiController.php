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
    public function index(Request $request)
    {
        $query = Transaksi::with('pelanggan')->latest();
        
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->whereHas('pelanggan', function($p) use ($request) {
                    $p->where('nama_pelanggan', 'LIKE', "%{$request->search}%");
                })->orWhere('jenis', 'LIKE', "%{$request->search}%");
            });
        }
        
        // Filter by jenis (penjualan, pemasukan, pengeluaran)
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // Filter by periode tanggal jika diberikan
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('tanggal', [$request->tanggal_mulai, $request->tanggal_akhir]);
        } elseif ($request->filled('tanggal_mulai')) {
            $query->whereDate('tanggal', '>=', $request->tanggal_mulai);
        } elseif ($request->filled('tanggal_akhir')) {
            $query->whereDate('tanggal', '<=', $request->tanggal_akhir);
        }
        
        $transaksis = $query->paginate(10)->withQueryString();
        return view('manajemen.transaksi.index', compact('transaksis'));
    }

    /**
     * Menampilkan form pembuatan transaksi baru.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        return view('manajemen.transaksi.create', compact('pelanggans'));
    }

    /**
     * Menyimpan transaksi baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:penjualan,pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
        ]);

        // Validasi: pelanggan_id harus ada untuk transaksi penjualan
        if ($validated['jenis'] === 'penjualan' && !$validated['pelanggan_id']) {
            return back()->withInput()->withErrors(['pelanggan_id' => 'Pelanggan harus dipilih untuk transaksi penjualan.']);
        }

        Transaksi::create($validated);
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Mencatat transaksi jenis: ' . $validated['jenis'] . ' sebesar ' . $validated['jumlah']]);

        return redirect()->route('manajemen.transaksi.index')->with('success', 'Transaksi berhasil dicatat.');
    }

    /**
     * Menampilkan form edit transaksi.
     */
    public function edit(Transaksi $transaksi)
    {
        $pelanggans = Pelanggan::all();
        return view('manajemen.transaksi.edit', compact('transaksi', 'pelanggans'));
    }

    /**
     * Memperbarui transaksi.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        $validated = $request->validate([
            'tanggal' => 'required|date',
            'jenis' => 'required|in:penjualan,pemasukan,pengeluaran',
            'jumlah' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string',
            'pelanggan_id' => 'nullable|exists:pelanggans,id',
        ]);

        // Validasi: pelanggan_id harus ada untuk transaksi penjualan
        if ($validated['jenis'] === 'penjualan' && !$validated['pelanggan_id']) {
            return back()->withInput()->withErrors(['pelanggan_id' => 'Pelanggan harus dipilih untuk transaksi penjualan.']);
        }

        $transaksi->update($validated);
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Memperbarui transaksi jenis: ' . $validated['jenis']]);

        return redirect()->route('manajemen.transaksi.index')->with('success', 'Transaksi berhasil diperbarui.');
    }

    /**
     * Menghapus transaksi.
     */
    public function destroy(Transaksi $transaksi)
    {
        $jenis = $transaksi->jenis;
        $transaksi->delete();
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Menghapus transaksi jenis: ' . $jenis]);

        return back()->with('success', 'Transaksi berhasil dihapus.');
    }
}