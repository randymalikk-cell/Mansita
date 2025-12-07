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
            <li class="breadcrumb-item active" aria-current="page">Edit Stok</li>
        </ol>
    </nav>

    <div class="form-card">
        <div class="form-header">
            <div class="form-icon blue">
                <i class="bi bi-pencil-square"></i>
            </div>
            <div class="form-header-content">
                <h2>Edit Data Stok</h2>
                <p>Perbarui informasi stok tahu putih dan tahu kuning</p>
            </div>
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
                       value="{{ old('total_tahu_kuning', $stok->total_tahu_kuning) }}"
                       min="0"
                       required>
                @error('total_tahu_kuning')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <small class="form-text">Jumlah tahu kuning dalam satuan unit</small>
            </div>

            <div class="form-group">
                <label class="form-label">Tanggal Update Terakhir</label>
                <input type="text" 
                       class="form-control" 
                       value="{{ $stok->tanggal_update->format('d F Y H:i') }}"
                       disabled>
                <small class="form-text">Waktu data stok terakhir diperbarui</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    <i class="bi bi-check-circle me-2"></i> Simpan Perubahan
                </button>
                <a href="{{ route('manajemen.stok.index') }}" class="btn-secondary">
                    <i class="bi bi-x-circle me-2"></i> Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
