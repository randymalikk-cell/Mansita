<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    // Otorisasi: Hanya Admin yang dapat mengakses (Use Case 4)
   public function __construct()
{
    $this->middleware('auth');
    $this->middleware(function ($request, $next) {

        // FIX AUTH ERROR
        if (!auth('web')->check() || auth('web')->user()->role !== 'admin') {
            abort(403, 'Akses hanya untuk Administrator.');
        }

        return $next($request);
    });
}


    /**
     * Menampilkan daftar pelanggan.
     */
    public function index()
    {
        $pelanggans = Pelanggan::latest()->paginate(10);
        return view('admin.pelanggans.index', compact('pelanggans'));
    }

    /**
     * Menampilkan form pembuatan pelanggan baru.
     */
    public function create()
    {
        return view('admin.pelanggans.create');
    }

    /**
     * Menyimpan data pelanggan baru.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:50',
            'jadwal_pengiriman' => 'required|string|max:100',
        ]);

        Pelanggan::create($validated);
        
        \App\Models\LogAktivitas::create(['user_id' => auth('web')->id(), 'aktivitas' => 'Menambah data pelanggan baru: ' . $validated['nama_pelanggan']]);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil ditambahkan.');
    }

    /**
     * Menampilkan form edit pelanggan.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('admin.pelanggans.edit', compact('pelanggan'));
    }

    /**
     * Memperbarui data pelanggan.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kontak' => 'required|string|max:50',
            'jadwal_pengiriman' => 'required|string|max:100',
        ]);

        $pelanggan->update($validated);
        
        \App\Models\LogAktivitas::create(['user_id' => auth('web')->id(), 'aktivitas' => 'Memperbarui data pelanggan: ' . $pelanggan->nama_pelanggan]);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil diperbarui.');
    }

    /**
     * Menghapus data pelanggan.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $nama = $pelanggan->nama_pelanggan;
        $pelanggan->delete();
        
        \App\Models\LogAktivitas::create(['user_id' => auth('web')->id(), 'aktivitas' => 'Menghapus data pelanggan: ' . $nama]);

        return redirect()->route('admin.pelanggan.index')->with('success', 'Data pelanggan berhasil dihapus.');
    }
}