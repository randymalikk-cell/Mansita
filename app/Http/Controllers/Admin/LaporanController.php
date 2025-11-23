<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Produksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;
// Asumsi Library sudah terinstall:
use Barryvdh\DomPDF\Facade\Pdf; // Pengganti Dompdf
use Maatwebsite\Excel\Facades\Excel; // Untuk PhpSpreadsheet

class LaporanController extends Controller
{
    // Otorisasi: Admin dan Pengurus dapat mengakses (Use Case 5)
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
     * Menampilkan daftar laporan yang pernah dibuat.
     */
    public function index()
    {
        $laporans = Laporan::with('dibuatOleh')->latest()->paginate(10);
        return view('admin.laporan.index', compact('laporans'));
    }

    /**
     * Menampilkan form untuk parameter laporan.
     */
    public function create()
    {
        return view('admin.laporan.create');
    }

    /**
     * Memproses pembuatan dan ekspor laporan (Use Case 5).
     */
    public function generate(Request $request)
    {
        $validated = $request->validate([
            'jenis' => 'required|in:produksi,keuangan',
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
            'format' => 'required|in:PDF,Excel',
        ]);

        // 1. Ambil Data
        if ($validated['jenis'] == 'produksi') {
            $data = Produksi::whereBetween('tanggal', [$validated['tanggal_mulai'], $validated['tanggal_akhir']])
                            ->get();
            $keterangan = 'Laporan Produksi';
        } else {
            // Laporan Keuangan mencakup semua Transaksi (Penjualan, Pemasukan, Pengeluaran)
            $data = Transaksi::whereBetween('tanggal', [$validated['tanggal_mulai'], $validated['tanggal_akhir']])
                             ->get();
            $keterangan = 'Laporan Keuangan';
        }
        
        $fileName = $validated['jenis'] . '_' . now()->format('Ymd_His') . '.' . strtolower($validated['format']);

        // 2. Simpan entri Laporan ke Database (Audit)
        $laporanDB = Laporan::create([
            'jenis' => $validated['jenis'],
            'tanggal' => now(),
            'keterangan' => $keterangan . ' (' . $validated['tanggal_mulai'] . ' s.d. ' . $validated['tanggal_akhir'] . ')',
            'format' => $validated['format'],
            'dibuat_oleh_user_id' => auth()->id(),
        ]);
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Mengekspor ' . $keterangan . ' dalam format ' . $validated['format']]);


        // 3. Ekspor berdasarkan format
        if ($validated['format'] === 'PDF') {
            // Menggunakan library Barryvdh\DomPDF
            $pdf = Pdf::loadView('exports.laporan_pdf', compact('data', 'laporanDB'));
            return $pdf->download($fileName);
        } elseif ($validated['format'] === 'Excel') {
            // Menggunakan library Maatwebsite\Excel
            // Anda perlu membuat class Export
            // return Excel::download(new \App\Exports\LaporanExport($data), $fileName);
            return back()->with('info', 'Laporan Excel sedang dibuat, mohon buat class Export terlebih dahulu. Data berhasil dicatat.');
        }
    }
}