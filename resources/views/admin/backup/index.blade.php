@extends('layouts.app')

@section('content')
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Backup & Restore</span>
</h2>
<div class="container-fluid">
    <h1 class="mb-4">Backup & Restore Data Sistem</h1>
    
    @include('components.alert')

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Aksi Pencadangan</h6>
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

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Riwayat Pencadangan</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tanggal & Waktu</th>
                            <th>Jenis</th>
                            <th>File Backup</th>
                            <th>Dibuat Oleh</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($backups as $backup)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $backup->tanggal }}</td>
                            <td>{{ ucfirst($backup->jenis) }}</td>
                            <td>{{ $backup->file_backup }}</td>
                            <td>{{ $backup->dibuatOleh->nama ?? 'Sistem Otomatis' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $backups->links() }}
            </div>
        </div>
    </div>
</div>
@endsection