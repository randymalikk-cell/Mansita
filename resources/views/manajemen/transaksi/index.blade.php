@extends('layouts.app')

@section('content')

{{-- HEADER --}}
<header class="flex justify-between items-center mb-4">
    <div>
        <h1 class="text-2xl font-semibold">Transaksi</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436; font-weight:700;">Transaksi</span>
</h2>

<div class="container-fluid">

    <h1 class="mb-4">Manajemen Transaksi (Penjualan & Keuangan)</h1>

    @include('components.alert')

    {{-- CARD --}}
    <div class="card" style="border-radius: 16px;">
    <div class="card-header bg-white d-flex justify-content-between align-items-center" 
         style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
        <h5 class="mb-0 fw-bold">Daftar Transaksi</h5>
        
        <div class="d-flex gap-2">
            <a href="{{ route('manajemen.transaksi.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Transaksi
            </a>

            <a href="{{ route('manajemen.laporan.create', [
                'jenis' => 'keuangan',
                'tanggal_mulai' => now()->startOfMonth()->toDateString(),
                'tanggal_akhir' => now()->toDateString(),
            ]) }}" class="btn btn-success btn-sm">
                <i class="fas fa-chart-line"></i> Buat Laporan Keuangan
            </a>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table mb-0">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Tanggal</th>
                        <th>Jenis</th>
                        <th>Jumlah</th>
                        <th>Pelanggan</th>
                        <th>Keterangan</th>
                        <th style="text-align: center;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($transaksis as $transaksi)
                    <tr>
                        <td>{{ $loop->iteration + ($transaksis->currentPage() - 1) * $transaksis->perPage() }}</td>
                        
                        <td>
                            <span class="fw-medium">{{ $transaksi->tanggal }}</span>
                        </td>

                        <td>
                            @php
                                $jenisClass = $transaksi->jenis === 'penjualan' ? 'role-admin' : 'role-pengurus';
                            @endphp
                            <span class="role-badge {{ $jenisClass }}">
                                {{ ucfirst($transaksi->jenis) }}
                            </span>
                        </td>

                        <td>
                            <span class="fw-semibold">Rp{{ number_format($transaksi->jumlah, 0, ',', '.') }}</span>
                        </td>

                        <td>
                            <div>{{ $transaksi->pelanggan->nama_pelanggan ?? '-' }}</div>
                        </td>

                        <td>
                            <div>{{ \Illuminate\Support\Str::limit($transaksi->keterangan, 40) }}</div>
                        </td>

                        <td style="text-align: center;">
                            <div class="d-flex gap-2 justify-content-center">
                                <a href="{{ route('manajemen.transaksi.edit', $transaksi->id) }}" 
                                   class="btn-action edit" 
                                   title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('manajemen.transaksi.destroy', $transaksi->id) }}" 
                                      method="POST" 
                                      style="display: inline;"
                                      onsubmit="return confirm('Yakin ingin menghapus transaksi ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action delete" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="text-muted">
                                <i class="bi bi-receipt" style="font-size: 48px;"></i>
                                <p class="mt-3 mb-0">Belum ada data transaksi</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if($transaksis->hasPages())
    <div class="card-footer bg-white" style="border-radius: 0 0 16px 16px; padding: 20px 24px; border-top: 1px solid #F1F5F9;">
        {{ $transaksis->links() }}
    </div>
    @endif
</div>
</div>

@endsection
