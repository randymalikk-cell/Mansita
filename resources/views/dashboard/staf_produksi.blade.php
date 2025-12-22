@extends('layouts.app')

@section('content')
<div class="container py-4">

    <!-- Header -->
    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h2 class="fw-bold mb-1">Dashboard Staf Produksi</h2>
            <p class="text-muted mb-0">Selamat datang, <strong>{{ Auth::user()->nama }}</strong>.</p>
            <small class="text-muted">Kelola dan input data produksi harian di sini.</small>
        </div>
        <div class="text-end">
            <a href="{{ route('staf-produksi.produksi.create') }}" class="btn btn-primary">
                <i class="fas fa-plus-circle me-2"></i>Input Produksi
            </a>
        </div>
    </div>

    @include('components.alert')

    <!-- Metrics -->
    <div class="row justify-content-center mb-5">
        <div class="col-lg-8">
            <div class="row g-3">
                <div class="col-sm-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 bg-primary text-white rounded-3 p-3">
                                <i class="fas fa-box-open fa-lg"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Produksi Hari Ini</div>
                                <div class="h5 mb-0">{{ $produksi_today ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-6">
                    <div class="card shadow-sm border-0 rounded-3 h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="me-3 bg-success text-white rounded-3 p-3">
                                <i class="fas fa-check-double fa-lg"></i>
                            </div>
                            <div>
                                <div class="small text-muted">Selesai</div>
                                <div class="h5 mb-0">{{ $produksi_selesai ?? 0 }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Actions Card -->
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="{{ route('staf-produksi.produksi.create') }}"
                               class="btn btn-primary w-100 py-4 shadow-sm rounded-3">
                                <i class="fas fa-plus-circle fa-2x mb-2 d-block"></i>
                                <span class="fw-semibold">Input Data Produksi</span>
                                <div class="small mt-1">Tambahkan data produksi hari ini</div>
                            </a>
                        </div>

                        <div class="col-md-6">
                            <a href="{{ route('staf-produksi.produksi.index') }}"
                               class="btn btn-outline-secondary w-100 py-4 shadow-sm rounded-3">
                                <i class="fas fa-history fa-2x mb-2 d-block"></i>
                                <span class="fw-semibold">Riwayat Produksi</span>
                                <div class="small mt-1">Lihat data produksi yang telah diinput</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
