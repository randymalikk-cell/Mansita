<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Produksi;
use App\Models\Stok;
use App\Models\Transaksi;
use App\Models\LogAktivitas;

class DashboardController extends Controller
{
    /**
     * Menampilkan dashboard berdasarkan role pengguna.
     */
    public function index()
    {
        $user = auth('web')->user();

        // Data umum untuk semua dashboard
        $totalProduksiHariIni = Produksi::whereDate('tanggal', today())->count();
        $stokTerbaru = Stok::latest('tanggal_update')->first();

        // Logika tampilan berdasarkan Role
        if ($user->role === 'admin') {
            /* ----------------------------- 
            TOTAL PRODUKSI HARI INI
            (jumlah putih + kuning)
            ------------------------------ */
            $totalProduksiHariIni = Produksi::whereDate('tanggal', today())
                ->selectRaw('SUM(jumlah_tahu_putih + jumlah_tahu_kuning) AS total')
                ->value('total');


            /* ----------------------------- 
            SISA STOK (ambil stok terbaru)
            ------------------------------ */
            $lastStok = Stok::orderBy('tanggal_update', 'desc')->first();

            $sisaStok = ($lastStok->jumlah_tahu_putih ?? 0) +
                        ($lastStok->jumlah_tahu_kuning ?? 0);


            /* ----------------------------- 
            TOTAL PESANAN
            ------------------------------ */
            $totalPesanan = Transaksi::count();


            /* ----------------------------- 
            TOTAL PENDAPATAN
            ------------------------------ */
            $totalPendapatan = Transaksi::where('jenis', 'penjualan')->sum('jumlah');

            /* ----------------------------- 
            AKTIVITAS TERBARU
            ------------------------------ */
            $aktivitasTerbaru = LogAktivitas::orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

            // Default: 30 hari terakhir
            $range = request('range', 30);

            $startDate = now()->subDays($range);

            // Ambil data berdasar rentang hari
            $produksi = Produksi::where('tanggal', '>=', $startDate)
                ->orderBy('tanggal', 'asc')
                ->get();

            // Generate label & data
            $labels = $produksi->pluck('tanggal')->map(function ($item) {
                return Carbon::parse($item)->format('d M');
            });

            $dataProduksi = $produksi->map(function ($p) {
                return $p->jumlah_tahu_putih + $p->jumlah_tahu_kuning;
            });


            return view('dashboard.admin', compact(
                'totalProduksiHariIni',
                'sisaStok',
                'totalPesanan',
                'totalPendapatan',
                'aktivitasTerbaru',
                'labels', 'dataProduksi', 'range'
            ));
        } elseif ($user->role === 'staf produksi') {
            // Tampilan Staf Produksi: Hanya fokus pada input Produksi
            return view('dashboard.staf_produksi', compact('totalProduksiHariIni'));
        } elseif ($user->role === 'pengurus') {
            /// ===== DASHBOARD KHUSUS PENGURUS =====
            // Pengurus hanya melihat laporan dan monitoring saja

            $aktivitasTerbaru = LogAktivitas::latest()->limit(5)->get();

            $totalLaporan = \App\Models\Laporan::count(); // jika punya tabel laporan
            $totalProduksi = Produksi::sum('jumlah_tahu_putih') + Produksi::sum('jumlah_tahu_kuning');

            return view('dashboard.pengurus', compact(
                'aktivitasTerbaru',
                'totalLaporan',
                'totalProduksi'
            ));
        }
        return redirect('/');
    }
}