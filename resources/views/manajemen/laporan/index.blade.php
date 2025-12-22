@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Laporan</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>

<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436; font-weight:700;">Laporan</span>
</h2>

<div class="container-fluid">

    <h1 class="mb-4">Riwayat Laporan yang Dibuat</h1>

    @include('components.alert')

    <div class="card" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
             style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Daftar Laporan Historis</h5>
            <a href="{{ route('manajemen.laporan.create') }}" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> Buat Laporan Baru
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 150px;">Tanggal Buat</th>
                            <th style="width: 150px;">Jenis Laporan</th>
                            <th>Keterangan</th>
                            <th style="width: 100px;">Format</th>
                            <th style="width: 200px;">Dibuat Oleh</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse($laporans as $laporan)
                        <tr>
                            <td>{{ $loop->iteration + ($laporans->currentPage() - 1) * $laporans->perPage() }}</td>
                            
                            <td>
                                <span class="fw-medium">{{ $laporan->tanggal }}</span>
                            </td>

                            <td>
                                @php
                                    $jenisClass = 'role-staff';
                                    if($laporan->jenis === 'produksi') $jenisClass = 'role-admin';
                                    elseif($laporan->jenis === 'keuangan') $jenisClass = 'role-pengurus';
                                @endphp
                                <span class="role-badge {{ $jenisClass }}">
                                    {{ ucfirst($laporan->jenis) }}
                                </span>
                            </td>

                            <td>
                                <div>{{ \Illuminate\Support\Str::limit($laporan->keterangan, 60) }}</div>
                            </td>

                            <td>
                                <span class="role-badge role-admin">
                                    {{ strtoupper($laporan->format) }}
                                </span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($laporan->dibuatOleh)
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($laporan->dibuatOleh->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $laporan->dibuatOleh->nama }}</div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </td>

                            <td style="text-align: center;">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('manajemen.laporan.download', $laporan) }}" class="btn-action edit" title="Download">
                                        <i class="bi bi-download"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-file-earmark-text" style="font-size: 48px;"></i>
                                    <p class="mt-3 mb-0">Tidak ada laporan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>
        </div>

        @if($laporans->hasPages())
        <div class="card-footer bg-white" style="border-radius: 0 0 16px 16px; padding: 20px 24px; border-top: 1px solid #F1F5F9;">
            {{ $laporans->links() }}
        </div>
        @endif
    </div>

</div>

@endsection
