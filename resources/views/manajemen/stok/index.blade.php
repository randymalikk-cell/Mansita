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


@endsection