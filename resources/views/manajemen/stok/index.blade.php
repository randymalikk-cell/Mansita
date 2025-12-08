@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Manajemen Stok</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>

    
</header>
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Manajemen Stok</span>
</h2>
<div class="container-fluid">
    <h1 class="mb-4">Ringkasan Stok & Inventori</h1>
    
    @include('components.alert')

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Stok Tahu Putih</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPutih) }} Pcs</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Stok Tahu Kuning</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalKuning) }} Pcs</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
            style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Riwayat Pencatatan Stok dari Produksi</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal Update</th>
                            <th>Tahu Putih (Pcs)</th>
                            <th>Tahu Kuning (Pcs)</th>
                            <th>Sumber Produksi</th>
                            <th>Diinput Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stoks as $stok)
                        <tr>
                            <td>{{ $loop->iteration + ($stoks->currentPage() - 1) * $stoks->perPage() }}</td>
                            <td>
                                <span class="fw-medium">{{ $stok->tanggal_update }}</span>
                            </td>
                            <td>{{ number_format($stok->total_tahu_putih) }}</td>
                            <td>{{ number_format($stok->total_tahu_kuning) }}</td>
                            <td>{{ $stok->produksi->tanggal ?? 'Penyesuaian Manual' }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($stok->produksi && $stok->produksi->user)
                                        <div>
                                            <div class="fw-semibold">{{ $stok->produksi->user->nama }}</div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                    <p class="mt-3 mb-0">Tidak ada data riwayat stok</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($stoks->hasPages())
        <div class="card-footer bg-white" style="border-radius: 0 0 16px 16px; padding: 20px 24px; border-top: 1px solid #F1F5F9;">
            {{ $stoks->links() }}
        </div>
        @endif
    </div>
</div>


@endsection