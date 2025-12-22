@extends('layouts.app')

@section('content')

<div class="container-fluid">

    {{-- HEADER --}}
    <div class="bg-white rounded-xl shadow-sm p-4 mb-4 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Pengurus</h1>
            <p class="text-sm text-gray-500">Sistem Manajemen Pabrik Tahu</p>
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button class="btn btn-outline-danger btn-sm flex items-center gap-2">
                <i class="bi bi-box-arrow-right"></i>
                Logout
            </button>
        </form>
    </div>

    {{-- STAT CARD --}}
    <div class="row g-4">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 rounded-xl">
                <div class="card-body flex items-center gap-3">
                    <div class="bg-blue-100 text-blue-600 p-3 rounded-full">
                        <i class="bi bi-file-earmark-text fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Laporan</h6>
                        <h3 class="fw-bold">{{ $totalLaporan }}</h3>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 col-lg-4">
            <div class="card shadow-sm border-0 rounded-xl">
                <div class="card-body flex items-center gap-3">
                    <div class="bg-green-100 text-green-600 p-3 rounded-full">
                        <i class="bi bi-gear fs-4"></i>
                    </div>
                    <div>
                        <h6 class="text-muted mb-0">Total Produksi</h6>
                        <h3 class="fw-bold">{{ $totalProduksi }}</h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- AKTIVITAS --}}
    <div class="card shadow-sm border-0 rounded-xl mt-5">
        <div class="card-header bg-white border-0">
            <h5 class="fw-bold mb-0">
                <i class="bi bi-clock-history me-2"></i> Aktivitas Terbaru
            </h5>
        </div>

        <div class="card-body">
            <ul class="list-group list-group-flush">
                @forelse ($aktivitasTerbaru as $akt)
                    <li class="list-group-item py-3">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="mb-1 fw-semibold">{{ $akt->aktivitas }}</p>
                                <small class="text-muted">
                                    {{ $akt->created_at->format('d M Y, H:i') }}
                                </small>
                            </div>
                            <span class="badge bg-light text-dark">
                                <i class="bi bi-info-circle"></i>
                            </span>
                        </div>
                    </li>
                @empty
                    <li class="list-group-item text-center text-muted py-4">
                        Belum ada aktivitas
                    </li>
                @endforelse
            </ul>
        </div>
    </div>

</div>

@endsection
