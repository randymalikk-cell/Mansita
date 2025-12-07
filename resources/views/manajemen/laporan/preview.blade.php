@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-2">Preview Laporan</h1>
        <p class="text-gray-600">{{ $laporan->keterangan }}</p>
    </div>

    <!-- Action Buttons -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('manajemen.laporan.download', $laporan) }}" 
               class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19v-7m0 0V5m0 7H5m7 0h7"></path>
                </svg>
                Download {{ $format === 'PDF' ? 'PDF' : 'Excel' }}
            </a>
            
            <a href="{{ route('manajemen.laporan.index') }}" 
               class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg hover:bg-gray-700 transition">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Kembali ke Daftar
            </a>
        </div>
    </div>

    <!-- Report Content -->
    <div class="bg-white rounded-lg shadow-md p-8">
        <div class="mb-8 border-b-4 border-green-500 pb-4">
            <h2 class="text-2xl font-bold text-green-600 mb-2">
                {{ $jenis === 'produksi' ? 'Laporan Produksi' : 'Laporan Keuangan' }}
            </h2>
            <p class="text-gray-600 text-sm">Tanggal Laporan: {{ now()->format('d F Y H:i:s') }}</p>
            <p class="text-gray-600 text-sm">Dibuat Oleh: {{ auth()->user()->nama }}</p>
        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto">
            @if(!empty($summary))
                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                    <a href="{{ route('manajemen.transaksi.index', ['jenis' => 'penjualan', 'tanggal_mulai' => $tanggal_mulai, 'tanggal_akhir' => $tanggal_akhir]) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md">
                        <div class="text-sm text-gray-500">Total Penjualan</div>
                        <div class="text-xl font-bold text-green-700">Rp {{ number_format($summary['totals']['penjualan'] ?? 0, 0, ',', '.') }}</div>
                    </a>
                    <a href="{{ route('manajemen.transaksi.index', ['jenis' => 'pemasukan', 'tanggal_mulai' => $tanggal_mulai, 'tanggal_akhir' => $tanggal_akhir]) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md">
                        <div class="text-sm text-gray-500">Total Pemasukan</div>
                        <div class="text-xl font-bold text-blue-700">Rp {{ number_format($summary['totals']['pemasukan'] ?? 0, 0, ',', '.') }}</div>
                    </a>
                    <a href="{{ route('manajemen.transaksi.index', ['jenis' => 'pengeluaran', 'tanggal_mulai' => $tanggal_mulai, 'tanggal_akhir' => $tanggal_akhir]) }}" class="block p-4 bg-white rounded-lg shadow hover:shadow-md">
                        <div class="text-sm text-gray-500">Total Pengeluaran</div>
                        <div class="text-xl font-bold text-red-700">Rp {{ number_format($summary['totals']['pengeluaran'] ?? 0, 0, ',', '.') }}</div>
                    </a>
                    <div class="block p-4 bg-white rounded-lg shadow">
                        <div class="text-sm text-gray-500">Saldo (Net)</div>
                        <div class="text-xl font-bold text-gray-800">Rp {{ number_format($summary['net'] ?? 0, 0, ',', '.') }}</div>
                    </div>
                </div>
            @endif
            @if($jenis === 'produksi')
                <table class="w-full">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold">Shift</th>
                            <th class="px-4 py-3 text-right font-semibold">Tahu Putih</th>
                            <th class="px-4 py-3 text-right font-semibold">Tahu Kuning</th>
                            <th class="px-4 py-3 text-left font-semibold">User</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalPutih = 0;
                            $totalKuning = 0;
                        @endphp
                        @forelse($data as $key => $item)
                            <tr class="border-b hover:bg-gray-50 {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-3">{{ $key + 1 }}</td>
                                <td class="px-4 py-3">{{ $item->tanggal }}</td>
                                <td class="px-4 py-3">{{ $item->shift }}</td>
                                <td class="px-4 py-3 text-right">{{ $item->jumlah_tahu_putih }}</td>
                                <td class="px-4 py-3 text-right">{{ $item->jumlah_tahu_kuning }}</td>
                                <td class="px-4 py-3">{{ $item->user->nama }}</td>
                            </tr>
                            @php
                                $totalPutih += $item->jumlah_tahu_putih;
                                $totalKuning += $item->jumlah_tahu_kuning;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-green-50 font-bold">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right">TOTAL:</td>
                            <td class="px-4 py-3 text-right">{{ $totalPutih }}</td>
                            <td class="px-4 py-3 text-right">{{ $totalKuning }}</td>
                            <td class="px-4 py-3"></td>
                        </tr>
                    </tfoot>
                </table>
            @else
                <table class="w-full">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th class="px-4 py-3 text-left font-semibold">No</th>
                            <th class="px-4 py-3 text-left font-semibold">Tanggal</th>
                            <th class="px-4 py-3 text-left font-semibold">Jenis</th>
                            <th class="px-4 py-3 text-right font-semibold">Jumlah</th>
                            <th class="px-4 py-3 text-left font-semibold">Keterangan</th>
                            <th class="px-4 py-3 text-left font-semibold">Pelanggan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $totalJumlah = 0;
                        @endphp
                        @forelse($data as $key => $item)
                            <tr class="border-b hover:bg-gray-50 {{ $loop->odd ? 'bg-white' : 'bg-gray-50' }}">
                                <td class="px-4 py-3">{{ $key + 1 }}</td>
                                <td class="px-4 py-3">{{ $item->tanggal }}</td>
                                <td class="px-4 py-3">
                                    <span class="inline-block px-3 py-1 rounded-full text-xs font-semibold
                                        @if($item->jenis === 'penjualan') bg-green-100 text-green-800
                                        @elseif($item->jenis === 'pemasukan') bg-blue-100 text-blue-800
                                        @else bg-red-100 text-red-800
                                        @endif">
                                        {{ ucfirst($item->jenis) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 text-right font-mono">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                                <td class="px-4 py-3 text-sm">{{ $item->keterangan ?? '-' }}</td>
                                <td class="px-4 py-3">{{ $item->pelanggan->nama_pelanggan ?? '-' }}</td>
                            </tr>
                            @php
                                $totalJumlah += $item->jumlah;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                    <tfoot class="bg-green-50 font-bold">
                        <tr>
                            <td colspan="3" class="px-4 py-3 text-right">TOTAL:</td>
                            <td class="px-4 py-3 text-right font-mono">Rp {{ number_format($totalJumlah, 0, ',', '.') }}</td>
                            <td colspan="2" class="px-4 py-3"></td>
                        </tr>
                    </tfoot>
                </table>
            @endif
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-8 text-center text-gray-500 text-sm">
        <p>Laporan ini dibuat secara otomatis oleh sistem Mansita</p>
        <p>Tanggal Cetak: {{ now()->format('d/m/Y H:i') }}</p>
    </div>
</div>
@endsection
