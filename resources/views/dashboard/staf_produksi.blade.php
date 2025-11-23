@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Dashboard Staf Produksi</h1>
    <p>Halo, {{ Auth::user()->nama }}. Tugas utama Anda adalah menginput data produksi.</p>

    @include('components.alert')

    <div class="row justify-content-center">
        <div class="col-md-6">
            <a href="{{ route('staf-produksi.produksi.create') }}" class="btn btn-primary btn-lg btn-block mb-3 shadow">
                <i class="fas fa-plus-circle mr-2"></i> Input Data Produksi Hari Ini
            </a>
            <a href="{{ route('staf-produksi.produksi.index') }}" class="btn btn-secondary btn-lg btn-block shadow">
                <i class="fas fa-history mr-2"></i> Lihat Riwayat Produksi Anda
            </a>
        </div>
    </div>
</div>
@endsection