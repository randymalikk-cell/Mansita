@extends('layouts.app')

@section('content')
<style>
    .breadcrumb-link {
        color: #6c6c6c;
        text-decoration: none;
        position: relative;
        font-weight: 600;
        padding-bottom: 2px;
    }

    .breadcrumb-link::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 0%;
        height: 2px;
        background: #2563eb;
        transition: width 0.25s ease-in-out;
    }

    .breadcrumb-link:hover::after {
        width: 100%;
    }

    .breadcrumb-link:hover {
        color: #2563eb;
    }

    .summary-card {
        border-radius: 16px;
        padding: 7px 24px;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 4px solid;
    }
    
    .summary-card.purple {
        border-left-color: #f70bebff;
    }

    .summary-card.blue {
        border-left-color: #3B82F6;
    }
    
    .summary-card.green {
        border-left-color: #10B981;
    }
    
    .summary-card.red {
        border-left-color: #f80404ff;
    }
    
    .delay-03 {
        animation-delay: 0.3s !important;
    }

    .delay-06 {
        animation-delay: 0.6s !important;
    }
    
    .delay-09 {
        animation-delay: 0.9s !important;
    }

    .summary-card .content {
        flex: 1;
    }
    
    .summary-card .content p {
        font-size: 13px;
        color: #64748B;
        margin-bottom: 4px;
    }
    
    .summary-card .content h2 {
        font-size: 32px;
        font-weight: 700;
        margin-bottom: 0;
        color: #1E293B;
    }
    
    .summary-card .icon-circle {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }
    
    .summary-card.purple .icon-circle {
        background: #f70bebff;
    }

    .summary-card.blue .icon-circle {
        background: #3B82F6;
    }
    
    .summary-card.green .icon-circle {
        background: #10B981;
    }
    
    .summary-card.red .icon-circle {
        background: #ff0000ff;
    }
    
    .role-badge {
        padding: 6px 14px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 12px;
        display: inline-block;
    }
    
    .role-admin {
        background: #FEE2E2;
        color: #991B1B;
    }
    
    .role-pengurus {
        background: #D1FAE5;
        color: #065F46;
    }
    
    .role-staff {
        background: #DBEAFE;
        color: #1E3A8A;
    }
    
    .table thead {
        background: #F8FAFC;
        font-weight: 600;
        font-size: 13px;
        color: #64748B;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    
    .table thead th {
        border: none;
        padding: 16px;
        white-space: nowrap;
    }
    
    .table tbody td {
        padding: 16px;
        vertical-align: middle;
        border-bottom: 1px solid #F1F5F9;
    }
    
    .table {
        table-layout: fixed;
        width: 100%;
    }
    
    .table thead th:nth-child(1),
    .table tbody td:nth-child(1) {
        width: 8%;
    }
    
    .table thead th:nth-child(2),
    .table tbody td:nth-child(2) {
        width: 22%;
    }
    
    .table thead th:nth-child(3),
    .table tbody td:nth-child(3) {
        width: 18%;
    }
    
    .table thead th:nth-child(4),
    .table tbody td:nth-child(4) {
        width: 15%;
    }
    
    .table thead th:nth-child(5),
    .table tbody td:nth-child(5) {
        width: 22%;
    }
    
    .table thead th:nth-child(6),
    .table tbody td:nth-child(6) {
        width: 15%;
        text-align: center;
    }
    
    .table tbody tr:hover {
        background: #F8FAFC;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 20px;
        margin-bottom: 24px;
    }
    
    .user-avatar {
        width: 40px;
        height: 40px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        color: white;
        font-size: 14px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .btn-action {
        width: 32px;
        height: 32px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .btn-action.edit {
        background: #EFF6FF;
        color: #2563EB;
    }
    
    .btn-action.delete {
        background: #FEF2F2;
        color: #DC2626;
    }
    
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .btn-primary {
        background: #10B981;
        border: none;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-primary:hover {
        background: #059669;
    }
    
    .btn-outline-primary {
        border: 2px solid #10B981;
        color: #10B981;
        background: white;
        padding: 10px 24px;
        border-radius: 8px;
        font-weight: 600;
    }
    
    .btn-outline-primary:hover {
        background: #10B981;
        color: white;
    }
    
    .form-control, .form-select {
        border: 1px solid #E2E8F0;
        border-radius: 8px;
        padding: 10px 14px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #10B981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
</style>

<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Manajemen Pengguna</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>

    <div class="flex items-center gap-4">
        <div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="dropdown-item text-danger" type="submit">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
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