<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produksi;
use App\Models\Stok;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard berdasarkan role pengguna.
     */
    public function index()
    {
        $user = auth()->user();

        // Data umum untuk semua dashboard
        $totalProduksiHariIni = Produksi::whereDate('tanggal', today())->count();
        $stokTerbaru = Stok::latest('tanggal_update')->first();

        // Logika tampilan berdasarkan Role
        if ($user->role === 'admin' || $user->role === 'pengurus') {
            // Tampilan Admin/Pengurus: Ringkasan Produksi, Stok, dan Keuangan
            return view('dashboard.admin', compact('totalProduksiHariIni', 'stokTerbaru'));
        } elseif ($user->role === 'staf produksi') {
            // Tampilan Staf Produksi: Hanya fokus pada input Produksi
            return view('dashboard.staf_produksi', compact('totalProduksiHariIni'));
        }

        return redirect('/');
    }
}