<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laporan;
use App\Models\Produksi;
use App\Models\Transaksi;
use Illuminate\Http\Request;

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
        return view('manajemen.laporan.index', compact('laporans'));
    }

    /**
     * Menampilkan form untuk parameter laporan.
     */
    public function create()
    {
        return view('manajemen.laporan.create');
    }

    /**
     * Memproses pembuatan dan preview laporan (Use Case 5).
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
        
        // Cek apakah ada data
        if ($data->isEmpty()) {
            return back()->with('warning', 'Tidak ada data untuk periode yang dipilih.');
        }
        
        $fileName = $validated['jenis'] . '_' . now()->format('Ymd_His');

        // 2. Simpan entri Laporan ke Database (Audit)
        $laporanDB = Laporan::create([
            'jenis' => $validated['jenis'],
            'tanggal' => now(),
            'keterangan' => $keterangan . ' (' . $validated['tanggal_mulai'] . ' s.d. ' . $validated['tanggal_akhir'] . ')',
            'format' => $validated['format'],
            'dibuat_oleh_user_id' => auth()->id(),
        ]);
        
        \App\Models\LogAktivitas::create(['user_id' => auth()->id(), 'aktivitas' => 'Membuat ' . $keterangan . ' dalam format ' . $validated['format']]);

        // 3. Siapkan ringkasan untuk preview (khusus keuangan)
        $summary = null;
        if ($validated['jenis'] === 'keuangan') {
            $totals = ['penjualan' => 0, 'pemasukan' => 0, 'pengeluaran' => 0];
            foreach ($data as $item) {
                $jenisTrans = strtolower($item->jenis ?? '');
                $jumlah = (float) ($item->jumlah ?? 0);
                if ($jenisTrans === 'penjualan') {
                    $totals['penjualan'] += $jumlah;
                } elseif ($jenisTrans === 'pemasukan') {
                    $totals['pemasukan'] += $jumlah;
                } elseif ($jenisTrans === 'pengeluaran') {
                    $totals['pengeluaran'] += $jumlah;
                } else {
                    // jika ada jenis lain, tambahkan ke pemasukan sebagai fallback
                    $totals['pemasukan'] += $jumlah;
                }
            }

            $summary = [
                'totals' => $totals,
                'net' => $totals['penjualan'] + $totals['pemasukan'] - $totals['pengeluaran'],
            ];
        }

        // 4. Tampilkan preview laporan
        $content = $this->buildReportHTML($data, $laporanDB, $validated['jenis']);
        
        return view('manajemen.laporan.preview', [
            'content' => $content,
            'fileName' => $fileName,
            'format' => $validated['format'],
            'laporan' => $laporanDB,
            'jenis' => $validated['jenis'],
            'data' => $data,
            'summary' => $summary,
            'tanggal_mulai' => $validated['tanggal_mulai'],
            'tanggal_akhir' => $validated['tanggal_akhir'],
        ]);
    }

    /**
     * Download laporan dalam format yang dipilih
     */
    public function download(Laporan $laporan)
    {
        // Ambil data berdasarkan jenis laporan dan periode
        $periode = $laporan->keterangan;
        
        if ($laporan->jenis === 'produksi') {
            // Parsing tanggal dari keterangan format: "Laporan Produksi (2025-12-07 s.d. 2025-12-07)"
            preg_match('/\((\d{4}-\d{2}-\d{2})\s+s\.d\.\s+(\d{4}-\d{2}-\d{2})\)/', $periode, $matches);
            if (count($matches) >= 3) {
                $data = Produksi::whereBetween('tanggal', [$matches[1], $matches[2]])->get();
            } else {
                $data = Produksi::whereDate('tanggal', $laporan->tanggal)->get();
            }
        } else {
            preg_match('/\((\d{4}-\d{2}-\d{2})\s+s\.d\.\s+(\d{4}-\d{2}-\d{2})\)/', $periode, $matches);
            if (count($matches) >= 3) {
                $data = Transaksi::whereBetween('tanggal', [$matches[1], $matches[2]])->get();
            } else {
                $data = Transaksi::whereDate('tanggal', $laporan->tanggal)->get();
            }
        }
        
        $fileName = $laporan->jenis . '_' . $laporan->tanggal->format('Ymd_His');
        
        if ($laporan->format === 'PDF') {
            return $this->generatePDF($data, $laporan, $fileName, $laporan->jenis);
        } elseif ($laporan->format === 'Excel') {
            return $this->generateCSV($data, $laporan, $fileName, $laporan->jenis);
        }
    }

    /**
     * Generate laporan dalam format HTML yang dapat dicetak sebagai PDF
     */
    private function generatePDF($data, $laporanDB, $fileName, $jenis)
    {
        $content = $this->buildReportHTML($data, $laporanDB, $jenis);
        
        // Return HTML view untuk dicetak
        return response()->view('exports.laporan_html', ['content' => $content, 'fileName' => $fileName], 200, [
            'Content-Type' => 'text/html; charset=utf-8',
        ]);
    }

    /**
     * Generate laporan dalam format CSV (Excel)
     */
    private function generateCSV($data, $laporanDB, $fileName, $jenis)
    {
        $csv = $this->buildReportCSV($data, $laporanDB, $jenis);
        
        // Set CSV filename dengan extension .xlsx untuk Excel
        $csvFileName = str_replace(['.pdf', 'PDF', 'Excel'], '', $fileName) . '.csv';
        
        return response($csv, 200, [
            'Content-Type' => 'application/csv; charset=utf-8-sig',
            'Content-Disposition' => "attachment; filename=\"{$csvFileName}\"",
        ]);
    }

    /**
     * Build HTML content untuk laporan
     */
    private function buildReportHTML($data, $laporanDB, $jenis)
    {
        $html = '<html><head><meta charset="UTF-8"><title>Laporan</title>';
        $html .= '<style>body { font-family: Arial, sans-serif; margin: 20px; }';
        $html .= 'table { border-collapse: collapse; width: 100%; margin-top: 20px; }';
        $html .= 'th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }';
        $html .= 'th { background-color: #4CAF50; color: white; }';
        $html .= 'h2 { color: #333; }</style></head><body>';
        
        $html .= '<h2>' . ($jenis === 'produksi' ? 'Laporan Produksi' : 'Laporan Keuangan') . '</h2>';
        $html .= '<p><strong>Tanggal Laporan:</strong> ' . now()->format('d/m/Y H:i') . '</p>';
        $html .= '<p><strong>Dibuat Oleh:</strong> ' . auth()->user()->nama . '</p>';
        $html .= '<p><strong>Periode:</strong> ' . $laporanDB->keterangan . '</p>';
        
        $html .= '<table>';
        
        if ($jenis === 'produksi') {
            $html .= '<tr><th>No</th><th>Tanggal</th><th>Shift</th><th>Tahu Putih</th><th>Tahu Kuning</th><th>User</th></tr>';
            foreach ($data as $key => $item) {
                $html .= '<tr>';
                $html .= '<td>' . ($key + 1) . '</td>';
                $html .= '<td>' . $item->tanggal . '</td>';
                $html .= '<td>' . $item->shift . '</td>';
                $html .= '<td>' . $item->jumlah_tahu_putih . '</td>';
                $html .= '<td>' . $item->jumlah_tahu_kuning . '</td>';
                $html .= '<td>' . $item->user->nama . '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr><th>No</th><th>Tanggal</th><th>Jenis</th><th>Jumlah</th><th>Keterangan</th><th>Pelanggan</th></tr>';
            foreach ($data as $key => $item) {
                $html .= '<tr>';
                $html .= '<td>' . ($key + 1) . '</td>';
                $html .= '<td>' . $item->tanggal . '</td>';
                $html .= '<td>' . ucfirst($item->jenis) . '</td>';
                $html .= '<td>Rp ' . number_format($item->jumlah, 0, ',', '.') . '</td>';
                $html .= '<td>' . $item->keterangan . '</td>';
                $html .= '<td>' . ($item->pelanggan ? $item->pelanggan->nama_pelanggan : '-') . '</td>';
                $html .= '</tr>';
            }
        }
        
        $html .= '</table>';
        $html .= '</body></html>';
        
        return $html;
    }

    /**
     * Build CSV content untuk laporan
     */
    private function buildReportCSV($data, $laporanDB, $jenis)
    {
        // BOM untuk UTF-8 agar Excel membaca dengan benar
        $csv = "\xEF\xBB\xBF";
        
        $csv .= "Laporan " . ($jenis === 'produksi' ? 'Produksi' : 'Keuangan') . "\n";
        $csv .= "Tanggal Laporan," . now()->format('d/m/Y H:i') . "\n";
        $csv .= "Dibuat Oleh," . auth()->user()->nama . "\n";
        $csv .= "Periode," . $laporanDB->keterangan . "\n";
        $csv .= "Total Data," . count($data) . " item\n";
        $csv .= "\n\n";
        
        if ($jenis === 'produksi') {
            $csv .= "No,Tanggal,Shift,Tahu Putih,Tahu Kuning,User\n";
            
            $totalPutih = 0;
            $totalKuning = 0;
            
            foreach ($data as $key => $item) {
                $csv .= ($key + 1) . ",";
                $csv .= $item->tanggal . ",";
                $csv .= $item->shift . ",";
                $csv .= $item->jumlah_tahu_putih . ",";
                $csv .= $item->jumlah_tahu_kuning . ",";
                $csv .= $item->user->nama . "\n";
                
                $totalPutih += $item->jumlah_tahu_putih;
                $totalKuning += $item->jumlah_tahu_kuning;
            }
            
            $csv .= "\n,,,,,\n";
            $csv .= "TOTAL,," . $totalPutih . "," . $totalKuning . "\n";
        } else {
            $csv .= "No,Tanggal,Jenis,Jumlah,Keterangan,Pelanggan\n";
            
            $totalJumlah = 0;
            
            foreach ($data as $key => $item) {
                $csv .= ($key + 1) . ",";
                $csv .= $item->tanggal . ",";
                $csv .= ucfirst($item->jenis) . ",";
                $csv .= $item->jumlah . ",";
                $csv .= '"' . str_replace('"', '""', $item->keterangan) . '",';
                $csv .= ($item->pelanggan ? $item->pelanggan->nama_pelanggan : '-') . "\n";
                
                $totalJumlah += $item->jumlah;
            }
            
            $csv .= "\n,,,,,\n";
            $csv .= "TOTAL,,,Rp " . number_format($totalJumlah, 0, ',', '.') . "\n";
        }
        
        return $csv;
    }
}