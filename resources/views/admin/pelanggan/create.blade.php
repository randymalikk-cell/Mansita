@extends('layouts.app')

@section('content')
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <a href="{{ route('admin.pelanggan.index') }}" class="breadcrumb-link">Manajemen Pelanggan</a>
    > <span style="color:#27d436ff; font-weight:700;">Tambah Pelanggan</span>
</h2>
<div class="container">
    <h1 class="mb-4">Tambah Data Pelanggan Baru</h1>
    
    @include('components.alert')

    <div class="card shadow">
        <div class="card-header">Form Data Pelanggan</div>
        <div class="card-body">
            <form action="{{ route('admin.pelanggan.store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required>
                    @error('nama_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="kontak">Nomor Kontak (HP/Telepon)</label>
                    <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak') }}" required>
                    @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jadwal_pengiriman">Jadwal Pengiriman</label>
                    <input type="text" class="form-control @error('jadwal_pengiriman') is-invalid @enderror" id="jadwal_pengiriman" name="jadwal_pengiriman" value="{{ old('jadwal_pengiriman') }}" placeholder="Contoh: Setiap Senin & Kamis" required>
                    @error('jadwal_pengiriman')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-4">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat') }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Simpan Pelanggan</button>
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection