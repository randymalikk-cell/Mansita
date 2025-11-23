@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Riwayat Produksi Saya</h1>
    
    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Data Produksi yang Telah Diinput</h6>
            <a href="{{ route('staf-produksi.produksi.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Input Produksi Baru</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Shift</th>
                            <th>Tahu Putih (Pcs)</th>
                            <th>Tahu Kuning (Pcs)</th>
                            <th>Waktu Input</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produksis as $produksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $produksi->tanggal }}</td>
                            <td>{{ $produksi->shift }}</td>
                            <td>{{ number_format($produksi->jumlah_tahu_putih) }}</td>
                            <td>{{ number_format($produksi->jumlah_tahu_kuning) }}</td>
                            <td>{{ $produksi->created_at->format('H:i:s') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $produksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection