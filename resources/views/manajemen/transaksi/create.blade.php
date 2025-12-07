@extends('layouts.app')

@section('content')
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <a href="{{ route('manajemen.transaksi.index') }}" class="breadcrumb-link">Transaksi</a>
    > <span style="color:#27d436ff; font-weight:700;">Tambah Transaksi</span>
</h2>
<div class="container">
    <h1 class="mb-4">Catat Transaksi Baru</h1>
    
    @include('components.alert')

    <div class="card shadow">
        <div class="card-header">Form Transaksi</div>
        <div class="card-body">
            <form action="{{ route('manajemen.transaksi.store') }}" method="POST">
                @csrf
                
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="tanggal">Tanggal Transaksi</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required>
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="jenis">Jenis Transaksi</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                            <option value="">Pilih Jenis</option>
                            <option value="penjualan" {{ old('jenis') == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                            <option value="pemasukan" {{ old('jenis') == 'pemasukan' ? 'selected' : '' }}>Pemasukan Lain</option>
                            <option value="pengeluaran" {{ old('jenis') == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran / Biaya</option>
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="pelanggan_id">Pelanggan (Hanya untuk Penjualan)</label>
                    <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id">
                        <option value="">-- Pilih Pelanggan (Kosongkan jika bukan Penjualan) --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id') == $pelanggan->id ? 'selected' : '' }}>{{ $pelanggan->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Field ini wajib diisi jika jenis transaksi adalah Penjualan.</small>
                    @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jumlah">Jumlah (Nilai Rupiah)</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah') }}" min="0" step="0.01" required>
                    @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-4">
                    <label for="keterangan">Keterangan (Detail Transaksi)</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan') }}</textarea>
                    @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Transaksi</button>
                <a href="{{ route('manajemen.transaksi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection