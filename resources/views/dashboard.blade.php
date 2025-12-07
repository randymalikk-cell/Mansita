@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-4xl font-bold text-gray-900 mb-2">Selamat Datang, {{ auth()->user()->nama }}!</h1>
    <p class="text-gray-600">Sistem Manajemen Pabrik Tahu Mansita DB</p>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    @if(auth()->user()->role === 'admin')
        <!-- Total Pengguna -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Pengguna</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\User::count() }}</p>
                </div>
                <i class="bi bi-people text-3xl text-blue-500 opacity-50"></i>
            </div>
        </div>

        <!-- Total Pelanggan -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Pelanggan</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Pelanggan::count() }}</p>
                </div>
                <i class="bi bi-person-badge text-3xl text-green-500 opacity-50"></i>
            </div>
        </div>

        <!-- Total Produksi -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Produksi</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Produksi::count() }}</p>
                </div>
                <i class="bi bi-gear text-3xl text-yellow-500 opacity-50"></i>
            </div>
        </div>

        <!-- Total Transaksi -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Total Transaksi</p>
                    <p class="text-3xl font-bold text-gray-900">{{ \App\Models\Transaksi::count() }}</p>
                </div>
                <i class="bi bi-receipt text-3xl text-purple-500 opacity-50"></i>
            </div>
        </div>
    @endif

    @if(in_array(auth()->user()->role, ['admin', 'pengurus']))
        <!-- Stok Tahu Putih -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Stok Tahu Putih</p>
                    <p class="text-3xl font-bold text-gray-900">
                        @php
                            $totalPutih = \App\Models\Stok::sum('total_tahu_putih') ?? 0;
                        @endphp
                        {{ number_format($totalPutih) }} pcs
                    </p>
                </div>
                <i class="bi bi-box-seam text-3xl text-blue-500 opacity-50"></i>
            </div>
        </div>

        <!-- Stok Tahu Kuning -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Stok Tahu Kuning</p>
                    <p class="text-3xl font-bold text-gray-900">
                        @php
                            $totalKuning = \App\Models\Stok::sum('total_tahu_kuning') ?? 0;
                        @endphp
                        {{ number_format($totalKuning) }} pcs
                    </p>
                </div>
                <i class="bi bi-box-seam text-3xl text-yellow-500 opacity-50"></i>
            </div>
        </div>
    @endif

    @if(auth()->user()->role === 'staf produksi')
        <!-- Produksi Hari Ini -->
        <div class="bg-white rounded-lg shadow p-6 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-gray-600 text-sm">Produksi Hari Ini</p>
                    <p class="text-3xl font-bold text-gray-900">
                        @php
                            $produksiHariIni = \App\Models\Produksi::whereDate('tanggal', now()->toDateString())->count() ?? 0;
                        @endphp
                        {{ $produksiHariIni }} kali
                    </p>
                </div>
                <i class="bi bi-check-circle text-3xl text-green-500 opacity-50"></i>
            </div>
        </div>
    @endif
</div>

<!-- Quick Links -->
<div class="bg-white rounded-lg shadow p-6 mb-8">
    <h2 class="text-2xl font-bold text-gray-900 mb-4">Menu Cepat</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('admin.users.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-blue-50 transition">
                <i class="bi bi-people text-2xl text-blue-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Manajemen Pengguna</p>
                <p class="text-sm text-gray-600">Kelola akun pengguna sistem</p>
            </a>
            <a href="{{ route('admin.pelanggan.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-green-50 transition">
                <i class="bi bi-person-badge text-2xl text-green-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Manajemen Pelanggan</p>
                <p class="text-sm text-gray-600">Kelola data pelanggan</p>
            </a>
            <a href="{{ route('admin.log_aktivitas.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-yellow-50 transition">
                <i class="bi bi-clock-history text-2xl text-yellow-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Log Aktivitas</p>
                <p class="text-sm text-gray-600">Audit trail sistem</p>
            </a>
            <a href="{{ route('admin.backup.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-purple-50 transition">
                <i class="bi bi-cloud-check text-2xl text-purple-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Backup & Restore</p>
                <p class="text-sm text-gray-600">Kelola backup database</p>
            </a>
        @endif

        @if(in_array(auth()->user()->role, ['admin', 'pengurus']))
            <a href="{{ route('manajemen.stok.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-blue-50 transition">
                <i class="bi bi-box-seam text-2xl text-blue-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Manajemen Stok</p>
                <p class="text-sm text-gray-600">Lihat ringkasan stok</p>
            </a>
            <a href="{{ route('manajemen.transaksi.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-green-50 transition">
                <i class="bi bi-receipt text-2xl text-green-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Transaksi</p>
                <p class="text-sm text-gray-600">Kelola transaksi bisnis</p>
            </a>
            <a href="{{ route('manajemen.laporan.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-yellow-50 transition">
                <i class="bi bi-file-text text-2xl text-yellow-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Laporan</p>
                <p class="text-sm text-gray-600">Buat & lihat laporan</p>
            </a>
        @endif

        @if(auth()->user()->role === 'staf produksi')
            <a href="{{ route('staf-produksi.produksi.index') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-blue-50 transition">
                <i class="bi bi-list-check text-2xl text-blue-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Riwayat Produksi</p>
                <p class="text-sm text-gray-600">Lihat data produksi</p>
            </a>
            <a href="{{ route('staf-produksi.produksi.create') }}" class="block p-4 border border-gray-300 rounded-lg hover:bg-green-50 transition">
                <i class="bi bi-plus-circle text-2xl text-green-600 mb-2"></i>
                <p class="font-semibold text-gray-900">Input Produksi</p>
                <p class="text-sm text-gray-600">Catat produksi baru</p>
            </a>
        @endif
    </div>
</div>

<!-- Info Box -->
<div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded">
    <p class="text-blue-900 font-semibold"><i class="bi bi-info-circle me-2"></i>Informasi Sistem</p>
    <p class="text-blue-800 text-sm mt-2">Anda login sebagai <strong>{{ auth()->user()->nama }}</strong> dengan role <strong>{{ ucfirst(auth()->user()->role) }}</strong>. Setiap aktivitas Anda dicatat dalam log sistem.</p>
</div>
@endsection
