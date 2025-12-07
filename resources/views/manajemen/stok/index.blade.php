@extends('layouts.app')

@section('content')
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Manajemen Stok</span>
</h2>
<div class="container-fluid">
    <h1 class="mb-4">Ringkasan Stok & Inventori</h1>
    
    @include('components.alert')

    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card shadow border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Total Stok Tahu Putih</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalPutih) }} Pcs</div>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-4">
            <div class="card shadow border-left-warning h-100 py-2">
                <div class="card-body">
                    <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Total Stok Tahu Kuning</div>
                    <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($totalKuning) }} Pcs</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pencatatan Stok dari Produksi</h6>
            <button type="button" class="btn btn-secondary btn-sm" data-bs-toggle="modal" data-bs-target="#adjustModal">
                <i class="fas fa-edit"></i> Koreksi Stok Manual
            </button>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Update</th>
                            <th>Tahu Putih (Pcs)</th>
                            <th>Tahu Kuning (Pcs)</th>
                            <th>Sumber Produksi</th>
                            <th>Diinput Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($stoks as $stok)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $stok->tanggal_update }}</td>
                            <td>{{ number_format($stok->total_tahu_putih) }}</td>
                            <td>{{ number_format($stok->total_tahu_kuning) }}</td>
                            <td>{{ $stok->produksi->tanggal ?? 'Penyesuaian Manual' }}</td>
                            <td>{{ $stok->produksi->user->nama ?? '-' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $stoks->links() }}
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="adjustModal" tabindex="-1" aria-labelledby="adjustModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('manajemen.stok.adjust') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="adjustModalLabel">Koreksi Stok Manual</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="text-danger">Perhatian! Proses ini akan menimpa total stok saat ini. Gunakan dengan bijak.</p>
                    <div class="form-group mb-3">
                        <label for="tahu_putih">Total Tahu Putih Saat Ini</label>
                        <input type="number" class="form-control" id="tahu_putih" name="tahu_putih" value="{{ $totalPutih }}" required>
                    </div>
                    <div class="form-group mb-3">
                        <label for="tahu_kuning">Total Tahu Kuning Saat Ini</label>
                        <input type="number" class="form-control" id="tahu_kuning" name="tahu_kuning" value="{{ $totalKuning }}" required>
                    </div>
                    <div class="form-group">
                        <label for="keterangan">Keterangan Koreksi</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="2"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Simpan Koreksi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection