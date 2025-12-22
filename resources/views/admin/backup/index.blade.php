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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($backups as $backup)
                        <tr>
                            <td>{{ $loop->iteration + ($backups->currentPage() - 1) * $backups->perPage() }}</td>
                            <td><span class="fw-medium">{{ \Carbon\Carbon::parse($backup->tanggal)->format('d/m/Y H:i:s') }}</span></td>
                            <td><span class="badge bg-info">{{ ucfirst($backup->jenis) }}</span></td>
                            <td>{{ $backup->file_backup }}</td>
                            <td>{{ $backup->dibuatOleh->nama ?? 'Sistem Otomatis' }}</td>
                            <td>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="{{ route('admin.backup.download', $backup->id) }}" 
                                       class="btn btn-sm btn-info" 
                                       title="Download file backup">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <button type="button" 
                                            class="btn btn-sm btn-warning" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#restoreModal{{ $backup->id }}"
                                            title="Restore dari backup ini">
                                        <i class="fas fa-undo"></i>
                                    </button>
                                    <form action="{{ route('admin.backup.delete', $backup->id) }}" 
                                          method="POST" 
                                          style="display:inline;" 
                                          onsubmit="return confirm('Yakin ingin menghapus backup ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                                class="btn btn-sm btn-danger" 
                                                title="Hapus backup">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>

                                <!-- Restore Modal -->
                                <div class="modal fade" id="restoreModal{{ $backup->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Restore Dari Backup</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <p><strong>File:</strong> {{ $backup->file_backup }}</p>
                                                <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($backup->tanggal)->format('d/m/Y H:i:s') }}</p>
                                                <p class="text-danger"><strong>⚠️ Peringatan:</strong> Proses restore akan menghapus semua data saat ini dan menggantinya dengan data dari backup ini. Lanjutkan?</p>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                <form action="{{ route('admin.backup.restore') }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <input type="hidden" name="backup_id" value="{{ $backup->id }}">
                                                    <button type="submit" class="btn btn-danger">
                                                        <i class="fas fa-undo me-1"></i> Ya, Lakukan Restore
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
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