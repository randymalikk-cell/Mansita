@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Buat Laporan</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <a href="{{ route('manajemen.laporan.index') }}" class="breadcrumb-link">Laporan</a>
    > <span style="color:#27d436ff; font-weight:700;">Buat Laporan</span>
</h2>
<div class="container">
    <h1 class="mb-4">Buat Laporan & Ekspor</h1>
    
    @include('components.alert')

    <div class="card shadow">
        <div class="card-header">Pilih Parameter Laporan</div>
        <div class="card-body">
            <form action="{{ route('manajemen.laporan.generate') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="jenis" class="form-label">Jenis Laporan</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="produksi" {{ old('jenis', request('jenis')) == 'produksi' ? 'selected' : '' }}>Laporan Produksi</option>
                            <option value="keuangan" {{ old('jenis', request('jenis')) == 'keuangan' ? 'selected' : '' }}>Laporan Keuangan (Transaksi)</option>
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="format" class="form-label">Format Ekspor</label>
                        <select class="form-select @error('format') is-invalid @enderror" id="format" name="format" required>
                            <option value="">Pilih Format</option>
                            <option value="PDF" {{ old('format') == 'PDF' ? 'selected' : '' }}>PDF (Dokumen)</option>
                            <option value="Excel" {{ old('format') == 'Excel' ? 'selected' : '' }}>Excel (Spreadsheet)</option>
                        </select>
                        @error('format')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_mulai" class="form-label">Tanggal Mulai</label>
                        <input type="date" class="form-control @error('tanggal_mulai') is-invalid @enderror" id="tanggal_mulai" name="tanggal_mulai" value="{{ old('tanggal_mulai', request('tanggal_mulai', now()->startOfMonth()->toDateString())) }}" required>
                        @error('tanggal_mulai')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="tanggal_akhir" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control @error('tanggal_akhir') is-invalid @enderror" id="tanggal_akhir" name="tanggal_akhir" value="{{ old('tanggal_akhir', request('tanggal_akhir', now()->toDateString())) }}" required>
                        @error('tanggal_akhir')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-success btn-block"><i class="fas fa-file-export mr-2"></i> Generate & Ekspor Laporan</button>
            </form>
        </div>
    </div>
</div>
@endsection