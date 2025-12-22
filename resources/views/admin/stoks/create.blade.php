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
            <li class="breadcrumb-item active" aria-current="page">Tambah Stok Baru</li>
        </ol>
    </nav>

    <div class="form-card">
        <div class="form-header">
            <div class="form-icon green">
                <i class="bi bi-plus-circle"></i>
            </div>
            <div class="form-header-content">
                <h2>Tambah Stok Baru</h2>
                <p>Masukkan data stok tahu putih dan tahu kuning</p>
            </div>
        </div>

        <form action="{{ route('manajemen.stok.store') }}" method="POST">
            @csrf

            <div class="form-group">
                
                <label class="form-label" for="total_tahu_putih">
                    Total Tahu Putih <span class="required">*</span>
                </label>
                <input type="number" 
                       class="form-control @error('total_tahu_putih') is-invalid @enderror" 
                       id="total_tahu_putih" 
                       name="total_tahu_putih" 
                       value="{{ old('total_tahu_putih') }}"
                       min="0"
                       required>
                @error('total_tahu_putih')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Jumlah tahu putih dalam satuan unit</small>
            </div>

            <div class="form-group">
                <label class="form-label" for="total_tahu_kuning">
                    Total Tahu Kuning <span class="required">*</span>
                </label>
                <input type="number" 
                       class="form-control @error('total_tahu_kuning') is-invalid @enderror" 
                       id="total_tahu_kuning" 
                       name="total_tahu_kuning" 
                       value="{{ old('total_tahu_kuning') }}"
                       min="0"
                       required>
                @error('total_tahu_kuning')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Jumlah tahu kuning dalam satuan unit</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle me-2"></i> Simpan
                </button>
                <a href="{{ route('manajemen.stok.index') }}" class="btn-secondary">
                    <i class="bi bi-x-circle me-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
