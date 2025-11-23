@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <h1 class="mb-4">Dashboard Administrator/Pengurus</h1>
    <p>Selamat datang, {{ Auth::user()->nama }} ({{ ucfirst(Auth::user()->role) }}).</p>
    
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($errors->any())
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <strong>Perhatian!</strong> Silakan periksa input Anda.
        <ul class="mt-2 mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif


    <div class="row">
        <div class="col-md-4 mb-4">
            <div class="card shadow border-left-primary h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Produksi Hari Ini</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $totalProduksiHariIni ?? 0 }} Entri</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-left-success h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Stok Tahu Putih (Aktual)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ number_format($stokTerbaru->total_tahu_putih ?? 0) }} Pcs</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-cube fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="card shadow border-left-info h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Total Pemasukan (Bulan Ini)</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">Rp{{ number_format(15000000, 0, ',', '.') }}</div>
                        </div>
                        <div class="col-auto"><i class="fas fa-dollar-sign fa-2x text-gray-300"></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card shadow mb-4">
        <div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">Aktivitas Terbaru</h6></div>
        <div class="card-body">
            <p>Tampilkan 5 Log Aktivitas terbaru atau Produksi terbaru di sini.</p>
        </div>
    </div>

</div>
@endsection