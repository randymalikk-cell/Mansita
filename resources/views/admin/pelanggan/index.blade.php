@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Manajemen Data Pelanggan</h1>
    
    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pelanggan Tetap</h6>
            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary btn-sm"><i class="fas fa-plus"></i> Tambah Pelanggan</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Jadwal Pengiriman</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pelanggans as $pelanggan)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $pelanggan->nama_pelanggan }}</td>
                            <td>{{ Str::limit($pelanggan->alamat, 50) }}</td>
                            <td>{{ $pelanggan->kontak }}</td>
                            <td>{{ $pelanggan->jadwal_pengiriman }}</td>
                            <td>
                                <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus data pelanggan ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $pelanggans->links() }}
            </div>
        </div>
    </div>
</div>
@endsection