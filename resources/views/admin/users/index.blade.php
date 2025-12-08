@extends('layouts.app')

@section('content')
<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Manajemen Pengguna</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>

<h2 class="py-4">
    <a href="{{ route('dashboard') }}" class="breadcrumb-link">Dashboard</a>
    > <span style="color:#27d436ff; font-weight:700;">Manajemen Pengguna</span>
</h2>

<div class="container-fluid px-0 py-2">

    <!-- Ringkasan Pengguna -->
    <div class="dashboard-grid">

        <div class="summary-card purple animate__animated animate__fadeInRight">
            <div class="content">
                <p class="mb-1">Total Pengguna</p>
                <h2 class="fw-bold">{{ $users->total() }}</h2>
            </div>
            <div class="icon-circle"></div>
        </div>
        
        <div class="summary-card red animate__animated animate__fadeInRight delay-03">
            <div class="content">
                <p class="mb-1">Admin</p>
                <h2 class="fw-bold">{{ $users->where('role', 'admin')->count() }}</h2>
            </div>
            <div class="icon-circle"></div>
        </div>

        <div class="summary-card green animate__animated animate__fadeInRight delay-06">
            <div class="content">
                <p class="mb-1">Pengurus</p>
                <h2 class="fw-bold">{{ $users->where('role', 'pengurus')->count() }}</h2>
            </div>
            <div class="icon-circle"></div>
        </div>

        <div class="summary-card blue animate__animated animate__fadeInRight delay-09">
            <div class="content">
                <p class="mb-1">Staf</p>
                <h2 class="fw-bold">{{ $users->where('role', 'staf produksi')->count() }}</h2>
            </div>
            <div class="icon-circle"></div>
        </div>

    </div>

    <!-- Search & Filter -->
    <div class="card mb-4" style="border-radius: 16px;">
        <div class="row align-items-center card-body">
            <div class="col-md-8">
                <!-- Left Side: Search & Filters -->
                <form method="GET" action="{{ route('admin.users.index') }}" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control" 
                           placeholder="🔍 Cari pengguna..." 
                           value="{{ request('search') }}"
                           style="max-width: 300px;">

                    <select name="role" class="form-select" style="max-width: 180px;">
                        <option value="">Semua Role</option>
                        <option value="admin" {{ request('role')=='admin'?'selected':'' }}>Admin</option>
                        <option value="pengurus" {{ request('role')=='pengurus'?'selected':'' }}>Pengurus</option>
                        <option value="staf produksi" {{ request('role')=='staf'?'selected':'' }}>Staf</option>
                    </select>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <button class="btn btn-outline-primary">
                    <a href="{{ route('admin.users.create') }}">
                        <i class="bi bi-plus-lg me-2"></i> Tambah Pengguna
                    </a>
                </button>
                
            </div>
        </div>
    </div>

    <!-- Tabel Pengguna -->
    <div class="card" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
             style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Daftar Pengguna</h5>
            <small class="text-muted">Menampilkan {{ $users->firstItem() }}-{{ $users->lastItem() }} dari {{ $users->total() }} pengguna</small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Role</th>
                            <th>Email</th>
                            <th style="text-align: center;">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration + ($users->currentPage() - 1) * $users->perPage() }}</td>
                                
                                <td>
                                    <div class="d-flex align-items-center gap-3">
                                        <div class="user-avatar">
                                            {{ strtoupper(substr($user->nama, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="fw-semibold">{{ $user->nama }}</div>
                                        </div>
                                    </div>
                                </td>

                                <td>
                                    <span class="fw-medium">{{ $user->username }}</span>
                                </td>

                                <td>
                                    @php
                                        $roleClass = 'role-staff';
                                        if($user->role === 'admin') $roleClass = 'role-admin';
                                        elseif($user->role === 'pengurus') $roleClass = 'role-pengurus';
                                    @endphp
                                    <span class="role-badge {{ $roleClass }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>

                                <td>
                                    <div>{{ $user->email ?? '-' }}</div>
                                </td>

                                <td style="text-align: center;">
                                    <div class="d-flex gap-2 justify-content-center">
                                        <a href="{{ route('admin.users.edit', $user->id) }}" 
                                           class="btn-action edit" 
                                           title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <form action="{{ route('admin.users.destroy', $user->id) }}" 
                                              method="POST" 
                                              style="display: inline;"
                                              onsubmit="return confirm('Yakin ingin menghapus pengguna ini?')">
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
                                        <i class="bi bi-person-x" style="font-size: 48px;"></i>
                                        <p class="mt-3 mb-0">Tidak ada data pengguna</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($users->hasPages())
        <div class="card-footer bg-white" style="border-top: 1px solid #F1F5F9; padding: 20px 24px;">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
        @endif
    </div>

</div>

@if(session('success'))
<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div class="toast show" role="alert">
        <div class="toast-header bg-success text-white">
            <strong class="me-auto">Berhasil</strong>
            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="toast"></button>
        </div>
        <div class="toast-body">
            {{ session('success') }}
        </div>
    </div>
</div>
@endif

@endsection