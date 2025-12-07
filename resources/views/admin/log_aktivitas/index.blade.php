@extends('layouts.app')

@section('content')
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Log Aktivitas</span>
</h2>
<div class="container-fluid">
    <h1 class="mb-4">Log Aktivitas Sistem (Audit Trail)</h1>
    <p class="text-muted">Mencatat semua aksi penting yang dilakukan oleh pengguna dalam sistem.</p>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Aktivitas</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Waktu</th>
                            <th>Pengguna</th>
                            <th>Role</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $log->created_at->format('Y-m-d H:i:s') }}</td>
                            <td>{{ $log->user->nama ?? 'Sistem' }}</td>
                            <td>{{ ucfirst($log->user->role ?? 'N/A') }}</td>
                            <td>{{ $log->aktivitas }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                {{ $logs->links() }}
            </div>
        </div>
    </div>
</div>
@endsection