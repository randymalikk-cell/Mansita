@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Manajemen Pelanggan</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>

<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Manajemen Pelanggan</span>
</h2>
<div class="container-fluid">
    <h1 class="mb-4">Manajemen Data Pelanggan</h1>
    
    @include('components.alert')

    <div class="card" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
             style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Daftar Pelanggan Tetap</h5>
            <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Tambah Pelanggan
            </a>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Pelanggan</th>
                            <th>Alamat</th>
                            <th>Kontak</th>
                            <th>Jadwal Pengiriman</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pelanggans as $pelanggan)
                        <tr>
                            <td>{{ $loop->iteration + ($pelanggans->currentPage() - 1) * $pelanggans->perPage() }}</td>
                            
                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    <div class="user-avatar">
                                        {{ strtoupper(substr($pelanggan->nama_pelanggan, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="fw-semibold">{{ $pelanggan->nama_pelanggan }}</div>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <div>{{ Str::limit($pelanggan->alamat, 50) }}</div>
                            </td>

                            <td>
                                <span class="fw-medium">{{ $pelanggan->kontak }}</span>
                            </td>

                            <td>
                                <span class="role-badge role-pengurus">
                                    {{ $pelanggan->jadwal_pengiriman }}
                                </span>
                            </td>

                            <td style="text-align: center;">
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ route('admin.pelanggan.edit', $pelanggan->id) }}" 
                                       class="btn-action edit" 
                                       title="Edit">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.pelanggan.destroy', $pelanggan->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('Yakin ingin menghapus data pelanggan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action delete" title="Hapus">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-people" style="font-size: 48px;"></i>
                                    <p class="mt-3 mb-0">Belum ada data pelanggan</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($pelanggans->hasPages())
        <div class="card-footer bg-white" style="border-radius: 0 0 16px 16px; padding: 20px 24px; border-top: 1px solid #F1F5F9;">
            {{ $pelanggans->links() }}
        </div>
        @endif
    </div>
</div>
@endsection