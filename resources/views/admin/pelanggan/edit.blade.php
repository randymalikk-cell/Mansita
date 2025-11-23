@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Data Pelanggan: {{ $pelanggan->nama_pelanggan }}</h1>
    
    @include('components.alert')

    <div class="card shadow">
        <div class="card-header">Form Edit Data Pelanggan</div>
        <div class="card-body">
            <form action="{{ route('admin.pelanggan.update', $pelanggan->id) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="form-group mb-3">
                    <label for="nama_pelanggan">Nama Pelanggan</label>
                    <input type="text" class="form-control @error('nama_pelanggan') is-invalid @enderror" id="nama_pelanggan" name="nama_pelanggan" value="{{ old('nama_pelanggan', $pelanggan->nama_pelanggan) }}" required>
                    @error('nama_pelanggan')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="kontak">Nomor Kontak (HP/Telepon)</label>
                    <input type="text" class="form-control @error('kontak') is-invalid @enderror" id="kontak" name="kontak" value="{{ old('kontak', $pelanggan->kontak) }}" required>
                    @error('kontak')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="jadwal_pengiriman">Jadwal Pengiriman</label>
                    <input type="text" class="form-control @error('jadwal_pengiriman') is-invalid @enderror" id="jadwal_pengiriman" name="jadwal_pengiriman" value="{{ old('jadwal_pengiriman', $pelanggan->jadwal_pengiriman) }}" required>
                    @error('jadwal_pengiriman')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-4">
                    <label for="alamat">Alamat Lengkap</label>
                    <textarea class="form-control @error('alamat') is-invalid @enderror" id="alamat" name="alamat" rows="3" required>{{ old('alamat', $pelanggan->alamat) }}</textarea>
                    @error('alamat')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary">Update Pelanggan</button>
                <a href="{{ route('admin.pelanggan.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection