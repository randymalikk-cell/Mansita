@extends('layouts.app')

@section('content')
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <a href="{{ route('staf-produksi.produksi.index') }}" class="breadcrumb-link">Input Produksi</a>
    > <span style="color:#27d436ff; font-weight:700;">Input Data Produksi</span>
</h2>
<div class="container">
    <h1 class="mb-4">Input Data Produksi Harian</h1>
    
    @include('components.alert')

    <div class="card shadow">
        <div class="card-header">Form Produksi</div>
        <div class="card-body">
            <form action="{{ route('staf-produksi.produksi.store') }}" method="POST">
                @csrf
                
                <div class="form-group mb-3">
                    <label for="tanggal">Tanggal Produksi</label>
                    <input type="date" class="form-control @error('tanggal') is-invalid @enderror" id="tanggal" name="tanggal" value="{{ old('tanggal', now()->toDateString()) }}" required>
                    @error('tanggal')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-3">
                    <label for="shift">Shift</label>
                    <input type="text" class="form-control @error('shift') is-invalid @enderror" id="shift" name="shift" value="{{ old('shift') }}" placeholder="Contoh: Pagi / Malam" required>
                    @error('shift')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <hr>
                
                <h5 class="mt-4 mb-3">Hasil Produksi</h5>
                
                <div class="form-group mb-3">
                    <label for="jumlah_tahu_putih">Jumlah Tahu Putih (Pcs)</label>
                    <input type="number" class="form-control @error('jumlah_tahu_putih') is-invalid @enderror" id="jumlah_tahu_putih" name="jumlah_tahu_putih" value="{{ old('jumlah_tahu_putih', 0) }}" min="0" required>
                    @error('jumlah_tahu_putih')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <div class="form-group mb-4">
                    <label for="jumlah_tahu_kuning">Jumlah Tahu Kuning (Pcs)</label>
                    <input type="number" class="form-control @error('jumlah_tahu_kuning') is-invalid @enderror" id="jumlah_tahu_kuning" name="jumlah_tahu_kuning" value="{{ old('jumlah_tahu_kuning', 0) }}" min="0" required>
                    @error('jumlah_tahu_kuning')<div class="invalid-feedback">{{ $message }}</div>@enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block">Simpan Data Produksi</button>
            </form>
        </div>
    </div>
</div>
@endsection