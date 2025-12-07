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
<div class="grid grid-cols-4 gap-5 py-4">

    <div class="stat-card green">
        <div class="icon">📋</div>
        <h3>Total Produksi Hari Ini</h3>
        <div class="value">1,250</div>
        <div class="subtitle text-green-600">+12% dari kemarin</div>
    </div>

    <div class="stat-card blue">
        <div class="icon">📦</div>
        <h3>Sisa Stok</h3>
        <div class="value">3,840</div>
        <div class="subtitle text-blue-600">Stok aman</div>
    </div>

    <div class="stat-card orange">
        <div class="icon">🛒</div>
        <h3>Total Pesanan</h3>
        <div class="value">87</div>
        <div class="subtitle text-orange-500">15 pending</div>
    </div>

    <div class="stat-card teal">
        <div class="icon">💰</div>
        <h3>Pendapatan</h3>
        <div class="value">Rp 12.5M</div>
        <div class="subtitle text-teal-600">+8% bulan ini</div>
    </div>
</div>

<!-- Content Row -->
<div class="grid grid-cols-3 gap-6 mt-6">

    <!-- Chart -->
    <div class="col-span-2 chart-container">
        <div class="flex justify-between items-center mb-6">
            <h2 class="font-semibold text-lg">Tren Produksi</h2>

            <div class="flex gap-2">
                <button class="filter-btn">CSV</button>
                <button class="filter-btn">PDF</button>
                <select class="filter-btn" style="padding-right: 32px;">
                    <option>30 Hari Terakhir</option>
                    <option>7 Hari Terakhir</option>
                    <option>90 Hari Terakhir</option>
                </select>
            </div>
        </div>

        <div style="position: relative; height: 300px;">
            <canvas id="chartProduksi"></canvas>
        </div>
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
@section('scripts')
<script>
const ctx = document.getElementById('chartProduksi');
new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
        datasets: [{
            label: 'Produksi (unit)',
            backgroundColor: '#10B981',
            borderRadius: 8,
            barThickness: 40,
            data: [800, 950, 1000, 1050, 1200, 1150, 1450]
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false },
            tooltip: {
                backgroundColor: '#1F2937',
                padding: 12,
                cornerRadius: 8,
                displayColors: false
            }
        },
        scales: { 
            y: { 
                beginAtZero: true,
                grid: {
                    color: '#F1F5F9',
                    drawBorder: false
                },
                ticks: {
                    color: '#64748B',
                    font: {
                        size: 12
                    }
                }
            },
            x: {
                grid: {
                    display: false
                },
                ticks: {
                    color: '#64748B',
                    font: {
                        size: 12,
                        weight: '500'
                    }
                }
            }
        }
    }
});
</script>
@endsection
