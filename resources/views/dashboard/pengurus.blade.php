@extends('layouts.app')

@section('content')

<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Dashboard Pengurus</h1>
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

<div class="row py-4">

    <div class="col-md-4">
        <div class="card shadow p-3">
            <h5>Total Laporan</h5>
            <h2>{{ $totalLaporan }}</h2>
        </div>
    </div>

    <div class="col-md-4">
        <div class="card shadow p-3">
            <h5>Total Produksi</h5>
            <h2>{{ $totalProduksi }}</h2>
        </div>
    </div>

</div>

<h4 class="mt-4">Aktivitas Terbaru</h4>
<ul class="list-group">
    @foreach ($aktivitasTerbaru as $akt)
        <li class="list-group-item">
            {{ $akt->aktivitas }} <br>
            <small>{{ $akt->created_at }}</small>
        </li>
    @endforeach
</ul>

@endsection
