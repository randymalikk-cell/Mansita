@extends('layouts.app')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        padding: 32px;
        max-width: 800px;
        margin: 0 auto;
    }
    
    .form-header {
        display: flex;
        align-items: center;
        gap: 16px;
        padding-bottom: 24px;
        border-bottom: 2px solid #F1F5F9;
        margin-bottom: 32px;
    }
    
    .form-icon {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        background: linear-gradient(135deg, #3B82F6 0%, #2563EB 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-size: 24px;
    }
    
    .form-header-content h2 {
        font-size: 24px;
        font-weight: 700;
        color: #1E293B;
        margin: 0;
    }
    
    .form-header-content p {
        font-size: 14px;
        color: #64748B;
        margin: 4px 0 0 0;
    }
    
    .form-group {
        margin-bottom: 24px;
    }
    
    .form-label {
        font-weight: 600;
        color: #334155;
        font-size: 14px;
        margin-bottom: 8px;
        display: block;
    }
    
    .form-label .required {
        color: #EF4444;
        margin-left: 4px;
    }
    
    .form-control, .form-select {
        border: 2px solid #E2E8F0;
        border-radius: 10px;
        padding: 12px 16px;
        font-size: 14px;
        transition: all 0.2s;
        width: 100%;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #3B82F6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.1);
        outline: none;
    }
    
    .form-control.is-invalid {
        border-color: #EF4444;
    }
    
    .form-control.is-invalid:focus {
        box-shadow: 0 0 0 4px rgba(239, 68, 68, 0.1);
    }
    
    .form-control:disabled {
        background: #F8FAFC;
        color: #64748B;
        cursor: not-allowed;
    }
    
    .invalid-feedback {
        display: block;
        color: #EF4444;
        font-size: 13px;
        margin-top: 6px;
        font-weight: 500;
    }
    
    .form-text {
        font-size: 13px;
        color: #64748B;
        margin-top: 6px;
        display: block;
    }
    
    .info-box {
        background: #EFF6FF;
        border-left: 4px solid #3B82F6;
        padding: 16px;
        border-radius: 8px;
        margin-bottom: 24px;
    }
    
    .info-box i {
        color: #3B82F6;
        font-size: 18px;
        margin-right: 8px;
    }
    
    .info-box p {
        margin: 0;
        color: #1E40AF;
        font-size: 14px;
    }
    
    .btn-primary {
        background: #3B82F6;
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s;
        color: white;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-primary:hover {
        background: #2563EB;
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(59, 130, 246, 0.3);
        color: white;
    }
    
    .btn-secondary {
        background: #F1F5F9;
        color: #64748B;
        border: none;
        padding: 12px 32px;
        border-radius: 10px;
        font-weight: 600;
        font-size: 15px;
        transition: all 0.2s;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    
    .btn-secondary:hover {
        background: #E2E8F0;
        color: #475569;
    }
    
    .form-actions {
        display: flex;
        gap: 12px;
        padding-top: 24px;
        border-top: 2px solid #F1F5F9;
        margin-top: 32px;
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    
    .breadcrumb-item a {
        color: #64748B;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb-item a:hover {
        color: #10B981;
    }
    
    .breadcrumb-item.active {
        color: #10B981;
        font-weight: 600;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #CBD5E1;
    }
    
    .stat-row {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 16px;
        margin-bottom: 24px;
        padding: 20px;
        background: #F8FAFC;
        border-radius: 12px;
    }
    
    .stat-item {
        text-align: center;
    }
    
    .stat-item .label {
        font-size: 13px;
        color: #64748B;
        margin-bottom: 8px;
    }
    
    .stat-item .value {
        font-size: 28px;
        font-weight: 700;
        color: #1E293B;
    }
    
    .stat-item.green .value {
        color: #10B981;
    }
    
    .stat-item.yellow .value {
        color: #F59E0B;
    }
</style>

<header class="flex justify-between items-center mb-4">
    <div>
        <h1 class="text-2xl font-semibold">Edit Stok</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>

<!-- Breadcrumb -->
<nav class="mb-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item">
            <a href="{{ route('manajemen.stok.index') }}">Manajemen Stok</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Edit Stok</li>
    </ol>
</nav>

<div class="container-fluid px-0">
    
    <div class="form-card">
        <div class="form-header">
            <div class="form-icon">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="form-header-content">
                <h2>Edit Data Stok</h2>
                <p>Perbarui informasi stok tahu putih dan tahu kuning</p>
            </div>
        </div>

        <!-- Current Stock Info -->
        <div class="stat-row">
            <div class="stat-item green">
                <div class="label">Stok Tahu Putih Saat Ini</div>
                <div class="value">{{ number_format($stok->total_tahu_putih) }}</div>
                <small class="text-muted">pcs</small>
            </div>
            <div class="stat-item yellow">
                <div class="label">Stok Tahu Kuning Saat Ini</div>
                <div class="value">{{ number_format($stok->total_tahu_kuning) }}</div>
                <small class="text-muted">pcs</small>
            </div>
        </div>

        <div class="info-box">
            <i class="bi bi-info-circle-fill"></i>
            <span style="color: #1E40AF; font-weight: 600;">Info:</span>
            <span style="color: #1E40AF;"> Perubahan stok akan langsung mempengaruhi total inventori sistem.</span>
        </div>

        <form action="{{ route('manajemen.stok.update', $stok->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label class="form-label" for="total_tahu_putih">
                    Total Tahu Putih <span class="required">*</span>
                </label>
                <input type="number" 
                       class="form-control @error('total_tahu_putih') is-invalid @enderror" 
                       id="total_tahu_putih" 
                       name="total_tahu_putih" 
                       value="{{ old('total_tahu_putih', $stok->total_tahu_putih) }}"
                       min="0"
                       placeholder="Masukkan jumlah tahu putih"
                       required>
                @error('total_tahu_putih')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
                <small class="form-text">Jumlah tahu putih dalam satuan pieces (pcs)</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="total_tahu_kuning">
                    Total Tahu Kuning <span class="required">*</span>
                </label>
                <input type="number" 
                       class="form-control @error('total_tahu_kuning') is-invalid @enderror" 
                       id="total_tahu_kuning" 
                       name="total_tahu_kuning" 
                       value="{{ old('total_tahu_kuning', $stok->total_tahu_kuning) }}"
                       min="0"
                       placeholder="Masukkan jumlah tahu kuning"
                       required>
                @error('total_tahu_kuning')
                    <div class="invalid-feedback">
                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                    </div>
                @enderror
                <small class="form-text">Jumlah tahu kuning dalam satuan pieces (pcs)</small>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Update Terakhir</label>
                <input type="text" 
                       class="form-control" 
                       value="{{ \Carbon\Carbon::parse($stok->tanggal_update)->format('d F Y H:i') }} WIB"
                       disabled>
                <small class="form-text">Waktu data stok terakhir diperbarui dalam sistem</small>
            </div>

            @if($stok->produksi)
            <div class="form-group">
                <label class="form-label">Sumber Data</label>
                <input type="text" 
                       class="form-control" 
                       value="Produksi Tanggal {{ \Carbon\Carbon::parse($stok->produksi->tanggal)->format('d F Y') }}"
                       disabled>
                <small class="form-text">Data stok berasal dari pencatatan produksi</small>
            </div>
            @endif

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle"></i> Simpan Perubahan
                </button>
                <a href="{{ route('manajemen.stok.index') }}" class="btn-secondary">
                    <i class="bi bi-x-circle"></i> Batal
                </a>
            </div>
        </form>
    </div>

</div>

@endsection