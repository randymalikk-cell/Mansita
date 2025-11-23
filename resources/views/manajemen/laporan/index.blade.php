@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Riwayat Laporan yang Dibuat</h1>
    
    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Laporan Historis</h6>
            <a href="{{ route('manajemen.laporan.create') }}" class="btn btn-success btn-sm"><i class="fas fa-plus"></i> Buat Laporan Baru</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal Buat</th>
                            <th>Jenis Laporan</th>
                            <th>Keterangan</th>
                            <th>Format</th>
                            <th>Dibuat Oleh</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($laporans as $laporan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $laporan->tanggal }}</td>
                            <td><span class="badge bg-{{ $laporan->jenis == 'produksi' ? 'info' : 'secondary' }} text-white">{{ ucfirst($laporan->jenis) }}</span></td>
                            <td>{{ Str::limit($laporan->keterangan, 60) }}</td>
                            <td><span class="badge bg-primary text-white">{{ $laporan->format }}</span></td>
                            <td>{{ $laporan->dibuatOleh->nama ?? 'N/A' }}</td>
                            <td>
                                <button class="btn btn-sm btn-outline-secondary disabled">Download</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $laporans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection