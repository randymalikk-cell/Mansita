@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Backup & Restore</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Backup & Restore</span>
</h2>
<div class="container-fluid">
    <h1 class="mb-4">Backup & Restore Data Sistem</h1>
    
    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-header bg-white d-flex justify-content-between align-items-center"
            style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Aksi Pencadangan</h5>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-6">
                    <form action="{{ route('admin.backup.execute') }}" method="POST" onsubmit="return confirm('Anda yakin ingin menjalankan proses Backup Manual sekarang?');">
                        @csrf
                        <button type="submit" class="btn btn-primary btn-block mb-2"><i class="fas fa-database mr-2"></i> Jalankan Backup Manual</button>
                    </form>
                    <small class="text-muted">Proses ini akan mencadangkan database dan menyimpannya ke lokasi yang dikonfigurasi.</small>
                </div>
                <div class="col-md-6">
                    <form action="{{ route('admin.backup.restore') }}" method="POST" onsubmit="return confirm('PERINGATAN! Anda yakin ingin menjalankan proses RESTORE DATA? Data saat ini akan ditimpa.');">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block mb-2"><i class="fas fa-undo mr-2"></i> Lakukan Restore Data</button>
                    </form>
                    <small class="text-danger">Gunakan fitur Restore dengan sangat hati-hati. Disarankan hanya oleh Admin IT.</small>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center"
            style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Riwayat Pencadangan</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal & Waktu</th>
                            <th>Jenis</th>
                            <th>File Backup</th>
                            <th>Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $backup)
                        <tr>
                            <td>{{ $loop->iteration + ($backups->currentPage() - 1) * $backups->perPage() }}</td>
                            <td><span class="fw-medium">{{ $backup->tanggal }}</span></td>
                            <td>{{ ucfirst($backup->jenis) }}</td>
                            <td>{{ $backup->file_backup }}</td>
                            <td>{{ $backup->dibuatOleh->nama ?? 'Sistem Otomatis' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                    <p class="mt-3 mb-0">Tidak ada data backup</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($backups->hasPages())
        <div class="card-footer bg-white"
            style="border-radius: 0 0 16px 16px; padding: 20px 24px; border-top: 1px solid #F1F5F9;">
            {{ $backups->links() }}
        </div>
        @endif
    </div>

</div>
@endsection