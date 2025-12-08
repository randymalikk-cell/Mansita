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
<!-- Statistik Cards -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 py-4">

    <!-- Card 1 - Produksi (Hijau) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Produksi Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">1,250</p>
                <p class="mt-1 text-sm text-green-600 font-semibold">+12% dari kemarin</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-2xl">
                📋
            </div>
        </div>
    </div>

    <!-- Card 2 - Stok (Biru) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Sisa Stok</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">3,840</p>
                <p class="mt-1 text-sm text-blue-600 font-semibold">Stok aman</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                📦
            </div>
        </div>
    </div>

    <!-- Card 3 - Pesanan (Oranye) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">87</p>
                <p class="mt-1 text-sm text-orange-600 font-semibold">15 pending</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-orange-100 flex items-center justify-center text-2xl">
                🛒
            </div>
        </div>
    </div>

    <!-- Card 4 - Pendapatan (Teal) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Pendapatan</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">Rp 12.5M</p>
                <p class="mt-1 text-sm text-teal-600 font-semibold">+8% bulan ini</p>
            </div>
            <div class="w-12 h-12 rounded-full bg-teal-100 flex items-center justify-center text-2xl">
                💰
            </div>
        </div>
    </div>

</div>

<!-- Content Row -->
<div class="grid grid-cols-3 gap-6 mt-6">

<!-- Chart Produksi + Export CSV & PDF -->
<div class="lg:col-span-2 bg-white p-6 rounded-xl shadow-sm border">
    <div class="flex justify-between items-center mb-6">
        <h2 class="font-semibold text-lg">Tren Produksi</h2>

        <div class="flex gap-2">
            <!-- Tombol CSV -->
            <button id="exportCsv" class="px-4 py-2 text-xs bg-green-600 text-white rounded hover:bg-green-700 transition">
                CSV
            </button>
            <!-- Tombol PDF -->
            <button id="exportPdf" class="px-4 py-2 text-xs bg-red-600 text-white rounded hover:bg-red-700 transition">
                PDF
            </button>

            <select id="rangeFilter" class="px-3 py-2 text-xs bg-gray-100 rounded cursor-pointer focus:outline-none">
                <option value="7">7 Hari</option>
                <option value="30" selected>30 Hari</option>
                <option value="90">90 Hari</option>
            </select>
        </div>
    </div>

    <div style="position: relative; height: 320px;">
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

<!-- h2canvas & jsPDF (untuk export PDF) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
const ctx = document.getElementById('chartProduksi');
const chartProduksi = new Chart(ctx, {
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
        maintainAspectRatio: false
    }
});

/* -------------------------------
    FILTER RANGE DATA CHART
-------------------------------- */
document.getElementById("rangeFilter").onchange = function () {
    const range = this.value;

    const data7  = [300, 450, 600, 700, 500, 650, 800];
    const data30 = [800, 950, 1000, 1050, 1200, 1150, 1450];
    const data90 = [500, 700, 900, 950, 1100, 1250, 1550];

    if (range == 7) chartProduksi.data.datasets[0].data = data7;
    if (range == 30) chartProduksi.data.datasets[0].data = data30;
    if (range == 90) chartProduksi.data.datasets[0].data = data90;

    chartProduksi.update();
};


/* -------------------------------
    EXPORT CSV
-------------------------------- */
document.getElementById("exportCsv").onclick = function () {

    let labels = chartProduksi.data.labels;
    let data = chartProduksi.data.datasets[0].data;

    let csv = "Hari,Produksi\n";

    for (let i = 0; i < labels.length; i++) {
        csv += `${labels[i]},${data[i]}\n`;
    }

    let blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
    let link = document.createElement("a");

    link.href = URL.createObjectURL(blob);
    link.download = "data-produksi.csv";
    link.click();
};


/* -------------------------------
    EXPORT PDF
-------------------------------- */
document.getElementById("exportPdf").onclick = function () {
    const { jsPDF } = window.jspdf;

    const chartArea = document.getElementById("chartProduksi").parentNode;

    html2canvas(chartArea).then(canvas => {
        const imgData = canvas.toDataURL("image/png");

        let pdf = new jsPDF({
            orientation: "landscape",
            unit: "px",
            format: [canvas.width, canvas.height]
        });

        pdf.addImage(imgData, "PNG", 0, 0, canvas.width, canvas.height);
        pdf.save("chart-produksi.pdf");
    });
};

</script>

@endsection

