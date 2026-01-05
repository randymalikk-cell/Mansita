@extends('layouts.app')

@section('content')
<style>
    .summary-card {
        border-radius: 16px;
        padding: 20px 24px;
        background: #ffffff;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        position: relative;
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-left: 4px solid;
    }
    
    .summary-card.green {
        border-left-color: #10B981;
    }
    
    .summary-card.yellow {
        border-left-color: #F59E0B;
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
    
    .summary-card.green .icon-circle {
        background: #10B981;
    }
    
    .summary-card.yellow .icon-circle {
        background: #F59E0B;
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
    
    .table tbody tr:hover {
        background: #F8FAFC;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 20px;
        margin-bottom: 24px;
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
        text-decoration: none;
    }
    
    .btn-action:hover {
        transform: translateY(-2px);
    }
    
    .btn-action.edit {
        background: #EFF6FF;
        color: #2563EB;
    }
    
    .card {
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
    }
    
    .breadcrumb {
        background: transparent;
        padding: 0;
        margin-bottom: 1.5rem;
    }
    
    .breadcrumb-item a {
        color: #64748B;
        text-decoration: none;
        transition: color 0.2s;
    }
    
    .breadcrumb-item a:hover {
        color: #10B981;
    }
    
    .breadcrumb-item.active {
        color: #10B981;
        font-weight: 600;
    }
    
    .breadcrumb-item + .breadcrumb-item::before {
        content: ">";
        color: #CBD5E1;
    }
</style>

<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Manajemen Stok</h1>
        <p class="text-gray-500 text-sm">Sistem Manajemen Pabrik Tahu</p>
    </div>
</header>

<!-- Breadcrumb -->
<nav class="mb-4" aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('dashboard') }}">Dashboard</a>
        </li>
        <li class="breadcrumb-item active" aria-current="page">Manajemen Stok</li>
    </ol>
</nav>

<div class="container-fluid px-0 py-2">

    @include('components.alert')

    <!-- Ringkasan Stok -->
    <div class="dashboard-grid">

        <div class="summary-card green">
            <div class="content">
                <p class="mb-1">Total Stok Tahu Putih</p>
                <h2 class="fw-bold">{{ number_format($totalPutih) }}</h2>
                <small class="text-muted">Pcs</small>
            </div>
            <div class="icon-circle"></div>
        </div>

        <div class="summary-card yellow">
            <div class="content">
                <p class="mb-1">Total Stok Tahu Kuning</p>
                <h2 class="fw-bold">{{ number_format($totalKuning) }}</h2>
                <small class="text-muted">Pcs</small>
            </div>
            <div class="icon-circle"></div>
        </div>

    </div>

    <!-- Tabel Riwayat Stok -->
    <div class="card" style="border-radius: 16px;">
        <div class="card-header bg-white d-flex justify-content-between align-items-center" 
             style="border-radius: 16px 16px 0 0; padding: 20px 24px; border-bottom: 1px solid #F1F5F9;">
            <h5 class="mb-0 fw-bold">Riwayat Pencatatan Stok dari Produksi</h5>
            <small class="text-muted">Total {{ $stoks->total() }} data</small>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 8%;">No</th>
                            <th style="width: 18%;">Tanggal Update</th>
                            <th style="width: 18%;">Tahu Putih (Pcs)</th>
                            <th style="width: 18%;">Tahu Kuning (Pcs)</th>
                            <th style="width: 18%;">Sumber Produksi</th>
                            <th style="width: 15%;">Diinput Oleh</th>
                            <th style="width: 10%; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($stoks as $stok)
                        <tr>
                            <td>{{ $loop->iteration + ($stoks->currentPage() - 1) * $stoks->perPage() }}</td>
                            <td>
                                <div>{{ \Carbon\Carbon::parse($stok->tanggal_update)->format('d M Y') }}</div>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ number_format($stok->total_tahu_putih) }}</span>
                                <small class="text-muted">pcs</small>
                            </td>
                            <td>
                                <span class="fw-semibold">{{ number_format($stok->total_tahu_kuning) }}</span>
                                <small class="text-muted">pcs</small>
                            </td>
                            <td>
                                @if($stok->produksi)
                                    <span class="badge" style="background: #D1FAE5; color: #065F46; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                        Produksi {{ \Carbon\Carbon::parse($stok->produksi->tanggal)->format('d/m/Y') }}
                                    </span>
                                @else
                                    <span class="badge" style="background: #FEF3C7; color: #92400E; padding: 6px 12px; border-radius: 6px; font-weight: 600;">
                                        Penyesuaian Manual
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($stok->produksi && $stok->produksi->user)
                                    <div class="fw-semibold">{{ $stok->produksi->user->nama }}</div>
                                    <small class="text-muted">{{ $stok->produksi->user->role }}</small>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <a href="{{ route('manajemen.stok.edit', $stok->id) }}" 
                                   class="btn-action edit" 
                                   title="Edit Stok">
                                    <i class="bi bi-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="bi bi-inbox" style="font-size: 48px;"></i>
                                    <p class="mt-3 mb-0">Tidak ada data riwayat stok</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($stoks->hasPages())
        <div class="card-footer bg-white" style="border-top: 1px solid #F1F5F9; padding: 20px 24px;">
            <div class="d-flex justify-content-between align-items-center">
                {{ $stoks->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>

</div>

@endsection