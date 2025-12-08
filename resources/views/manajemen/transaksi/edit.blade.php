@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center mb-4">
    <div>
        <h1 class="text-2xl font-semibold">Edit Transaksi</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <a href="{{ route('manajemen.transaksi.index') }}" class="breadcrumb-link">Transaksi</a>
    > <span style="color:#27d436ff; font-weight:700;">Edit Transaksi</span>
</h2>
<div class="container">
    <h1 class="mb-4">Edit Transaksi</h1>
    
    @include('components.alert')

    <div class="card shadow">
        <div class="card-header">Form Edit Transaksi</div>
        <div class="card-body">
            <form action="{{ route('manajemen.transaksi.update', $transaksi->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="tanggal">Tanggal Transaksi</label>
                        <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', $transaksi->tanggal) }}" required>
                        @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="jenis">Jenis Transaksi</label>
                        <select class="form-select @error('jenis') is-invalid @enderror" id="jenis" name="jenis" required>
                            <option value="penjualan" {{ old('jenis', $transaksi->jenis) == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                            <option value="pemasukan" {{ old('jenis', $transaksi->jenis) == 'pemasukan' ? 'selected' : '' }}>Pemasukan Lain</option>
                            <option value="pengeluaran" {{ old('jenis', $transaksi->jenis) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran / Biaya</option>
                        </select>
                        @error('jenis')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
                
                <div class="form-group mb-3">
                    <label for="pelanggan_id">Pelanggan (Hanya untuk Penjualan)</label>
                    <select class="form-select @error('pelanggan_id') is-invalid @enderror" id="pelanggan_id" name="pelanggan_id">
                        <option value="">-- Pilih Pelanggan (Kosongkan jika bukan Penjualan) --</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}" {{ old('pelanggan_id', $transaksi->pelanggan_id) == $pelanggan->id ? 'selected' : '' }}>{{ $pelanggan->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                    <small class="form-text text-muted">Field ini wajib diisi jika jenis transaksi adalah Penjualan.</small>
                    @error('pelanggan_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="keterangan">Keterangan (Detail Transaksi)</label>
                    <textarea class="form-control @error('keterangan') is-invalid @enderror" id="keterangan" name="keterangan" rows="3">{{ old('keterangan', $transaksi->keterangan) }}</textarea>
                    @error('keterangan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jumlah">Jumlah (Nilai Rupiah)</label>
                    <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $transaksi->jumlah) }}" min="0" step="0.01" required>
                    @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-4">
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    <a href="{{ route('manajemen.transaksi.index') }}" class="btn btn-secondary">Batal</a>
                </div>

                <button type="submit" class="btn btn-primary">Update Transaksi</button>
                <a href="{{ route('manajemen.transaksi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
