@extends('layouts.app')

@section('content')
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
                        <label for="tipe">Tipe Transaksi</label>
                        <select class="form-select @error('tipe') is-invalid @enderror" id="tipe" name="tipe" required>
                            <option value="penjualan" {{ old('tipe', $transaksi->tipe) == 'penjualan' ? 'selected' : '' }}>Penjualan</option>
                            <option value="pemasukan" {{ old('tipe', $transaksi->tipe) == 'pemasukan' ? 'selected' : '' }}>Pemasukan</option>
                            <option value="pengeluaran" {{ old('tipe', $transaksi->tipe) == 'pengeluaran' ? 'selected' : '' }}>Pengeluaran</option>
                        </select>
                        @error('tipe')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <div class="form-group mb-3">
                    <label for="deskripsi">Deskripsi / Keterangan</label>
                    <textarea class="form-control @error('deskripsi') is-invalid @enderror" id="deskripsi" name="deskripsi" rows="3">{{ old('deskripsi', $transaksi->deskripsi) }}</textarea>
                    @error('deskripsi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="jumlah">Jumlah (Rp)</label>
                        <input type="number" class="form-control @error('jumlah') is-invalid @enderror" id="jumlah" name="jumlah" value="{{ old('jumlah', $transaksi->jumlah) }}" step="0.01" required>
                        @error('jumlah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="col-md-6 form-group mb-3">
                        <label for="status">Status</label>
                        <select class="form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="pending" {{ old('status', $transaksi->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="selesai" {{ old('status', $transaksi->status) == 'selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="batal" {{ old('status', $transaksi->status) == 'batal' ? 'selected' : '' }}>Batal</option>
                        </select>
                        @error('status')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update Transaksi</button>
                <a href="{{ route('manajemen.transaksi.index') }}" class="btn btn-secondary">Batal</a>
            </form>
        </div>
    </div>
</div>
@endsection
