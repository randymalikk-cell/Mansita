@extends('layouts.app')

@section('content')

<header class="flex justify-between items-center">
    <div>
        <h1 class="text-2xl font-semibold">Dashboard</h1>
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

<!-- Statistik Cards -->
<div class="grid grid-cols-4 gap-4 mt-6">

    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Total Produksi Hari Ini</p>
        <h2 class="text-2xl font-bold mt-1">1,250</h2>
        <p class="text-green-600 text-xs mt-1">+12% dari kemarin</p>
    </div>

    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Sisa Stok</p>
        <h2 class="text-2xl font-bold mt-1">3,840</h2>
        <p class="text-green-600 text-xs mt-1">Stok aman</p>
    </div>

    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Total Pesanan</p>
        <h2 class="text-2xl font-bold mt-1">87</h2>
        <p class="text-orange-500 text-xs mt-1">15 pending</p>
    </div>

    <div class="bg-white p-5 rounded-lg shadow">
        <p class="text-gray-500 text-sm">Pendapatan</p>
        <h2 class="text-2xl font-bold mt-1">Rp 12.5M</h2>
        <p class="text-green-600 text-xs mt-1">+8% bulan ini</p>
    </div>
</div>

<!-- Content Row -->
<div class="grid grid-cols-3 gap-6 mt-6">

    <!-- Chart -->
    <div class="col-span-2 bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="font-semibold">Tren Produksi</h2>

            <select class="border rounded px-2 py-1 text-sm">
                <option>30 Hari Terakhir</option>
                <option>7 Hari Terakhir</option>
            </select>
        </div>

        <canvas id="chartProduksi" height="110"></canvas>
    </div>

    <!-- Aktivitas -->
    <div class="bg-white p-6 rounded-lg shadow">
        <h2 class="font-semibold mb-4">Aktivitas Terbaru</h2>

        <ul class="space-y-4 text-sm">

            <li>
                <p class="font-semibold">Produksi Tahu Putih</p>
                <p class="text-gray-600 text-xs">500 unit ditambahkan • 2 jam lalu</p>
            </li>

            <li>
                <p class="font-semibold">Pelanggan Baru</p>
                <p class="text-gray-600 text-xs">Warung Ibu Budi terdaftar • 3 jam lalu</p>
            </li>

            <li>
                <p class="font-semibold">Pesanan Baru</p>
                <p class="text-gray-600 text-xs">42 unit Tahu Kuning • 4 jam lalu</p>
            </li>

            <li>
                <p class="font-semibold">Stok Menipis</p>
                <p class="text-gray-600 text-xs">Tahu Putih &lt; 100 unit • 5 jam lalu</p>
            </li>

        </ul>
    </div>

</div>

@endsection

@section('scripts')
<script>
const ctx = document.getElementById('chartProduksi');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
            backgroundColor: '#16a34a',
            data: [800, 960, 1000, 1050, 1030, 1150, 1250]
        }]
    },
    options: {
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true } }
    }
});
</script>
@endsection
