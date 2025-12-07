@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <!-- Breadcrumb -->
    <nav class="mb-6" style="--bs-breadcrumb-divider: '/';">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('manajemen.stok.index') }}" class="breadcrumb-link">Stok</a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Detail Stok</li>
        </ol>
    </nav>

    <div class="form-card">
        <div class="form-header">
            <div class="form-icon green">
                <i class="bi bi-info-circle"></i>
            </div>
            <div class="form-header-content">
                <h2>Detail Data Stok</h2>
                <p>Informasi lengkap stok tahu putih dan tahu kuning</p>
            </div>
        </div>

        <div style="padding: 24px;">
            <div class="form-group">
                <label class="form-label">Total Tahu Putih</label>
                <div style="padding: 12px 16px; background: #F8FAFC; border-radius: 8px; border-left: 4px solid #10B981;">
                    <strong style="font-size: 24px; color: #10B981;">{{ $stok->total_tahu_putih }}</strong>
                    <span style="color: #64748B; margin-left: 8px;">unit</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Total Tahu Kuning</label>
                <div style="padding: 12px 16px; background: #F8FAFC; border-radius: 8px; border-left: 4px solid #F59E0B;">
                    <strong style="font-size: 24px; color: #F59E0B;">{{ $stok->total_tahu_kuning }}</strong>
                    <span style="color: #64748B; margin-left: 8px;">unit</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Total Stok Keseluruhan</label>
                <div style="padding: 12px 16px; background: #F8FAFC; border-radius: 8px; border-left: 4px solid #3B82F6;">
                    <strong style="font-size: 24px; color: #3B82F6;">{{ $stok->total_tahu_putih + $stok->total_tahu_kuning }}</strong>
                    <span style="color: #64748B; margin-left: 8px;">unit</span>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Update Terakhir</label>
                <div style="padding: 12px 16px; background: #F8FAFC; border-radius: 8px;">
                    <strong style="color: #334155;">{{ $stok->tanggal_update->format('d F Y - H:i:s') }}</strong>
                </div>
            </div>

            @if($stok->produksi_id)
            <div class="form-group">
                <label class="form-label">Dari Produksi</label>
                <div style="padding: 12px 16px; background: #F8FAFC; border-radius: 8px;">
                    <strong style="color: #334155;">{{ $stok->produksi->nama_produk ?? 'Produksi Terhapus' }}</strong>
                </div>
            </div>
            @endif
        </div>

        <div class="form-actions">
            <a href="{{ route('manajemen.stok.edit', $stok->id) }}" class="btn-primary">
                <i class="bi bi-pencil-square me-2"></i> Edit
            </a>
            <a href="{{ route('manajemen.stok.index') }}" class="btn-secondary">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>
    </div>
</div>
@endsection
