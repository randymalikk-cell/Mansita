@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Log Aktivitas</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>
<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Log Aktivitas</span>
</h2>
<div class="container-fluid">
    <h1 class="mb-1">Log Aktivitas Sistem (Audit Trail)</h1>
    <p class="text-muted mb-4">Mencatat semua aksi penting yang dilakukan oleh pengguna dalam sistem.</p>

    <div class="card" style="border-radius: 16px;">
        <div class="card-header bg-white" 
             style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Daftar Aktivitas</h5>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 60px;">No</th>
                            <th style="width: 180px;">Waktu</th>
                            <th style="width: 200px;">Pengguna</th>
                            <th style="width: 150px;">Role</th>
                            <th>Aktivitas</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                        <tr>
                            <td>{{ $loop->iteration + ($logs->currentPage() - 1) * $logs->perPage() }}</td>
                            
                            <td>
                                <span class="fw-medium">{{ $log->created_at->format('Y-m-d H:i:s') }}</span>
                            </td>

                            <td>
                                <div class="d-flex align-items-center gap-3">
                                    @if($log->user)
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($log->user->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $log->user->nama }}</div>
                                        </div>
                                    @else
                                        <div class="user-avatar" style="background: #6c757d;">
                                            S
                                        </div>
                                        <div>
                                            <div class="fw-semibold text-muted">Sistem</div>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <td>
                                @if($log->user)
                                    @php
                                        $roleClass = 'role-staff';
                                        if($log->user->role === 'admin') $roleClass = 'role-admin';
                                        elseif($log->user->role === 'pengurus') $roleClass = 'role-pengurus';
                                    @endphp
                                    <span class="role-badge {{ $roleClass }}">
                                        {{ ucfirst($log->user->role) }}
                                    </span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>

                            <td>
                                <div>{{ $log->aktivitas }}</div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-clock-history" style="font-size: 48px;"></i>
                                    <p class="mt-3 mb-0">Belum ada log aktivitas</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($logs->hasPages())
        <div class="card-footer bg-white" style="border-radius: 0 0 16px 16px; padding: 20px 24px; border-top: 1px solid #F1F5F9;">
            {{ $logs->links() }}
        </div>
        @endif
    </div>
</div>
@endsection