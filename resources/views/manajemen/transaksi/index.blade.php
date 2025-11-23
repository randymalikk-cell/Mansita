@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Manajemen Transaksi (Penjualan & Keuangan)</h1>
    
    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Transaksi</h6>
            <a href="{{ route('manajemen.transaksi.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Transaksi</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal</th>
                            <th>Jenis</th>
                            <th>Jumlah (Rp)</th>
                            <th>Pelanggan</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($transaksis as $transaksi)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaksi->tanggal }}</td>
                            <td><span class="badge bg-{{ $transaksi->jenis == 'penjualan' ? 'success' : 'warning' }} text-white">{{ ucfirst($transaksi->jenis) }}</span></td>
                            <td>Rp{{ number_format($transaksi->jumlah, 0, ',', '.') }}</td>
                            <td>{{ $transaksi->pelanggan->nama_pelanggan ?? 'N/A' }}</td>
                            <td>{{ Str::limit($transaksi->keterangan, 40) }}</td>
                            <td>
                                <a href="{{ route('manajemen.transaksi.edit', $transaksi->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('manajemen.transaksi.destroy', $transaksi->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $transaksis->links() }}
            </div>
        </div>
    </div>
</div>
@endsection