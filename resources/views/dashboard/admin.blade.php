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
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 py-4">

    <!-- Card 1 - Produksi (Hijau) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Produksi Hari Ini</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format($totalProduksiHariIni ?? 0) }}
                </p>
                <!-- <p class="mt-1 text-sm text-green-600 font-semibold">+12% dari kemarin</p> -->
            </div>
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center text-2xl">
                📋
            </div>
        </div>
    </div>

    <!-- Card 2 - Stok Tahu Putih (Biru) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Stok Tahu Putih</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format($stokPutih ?? 0) }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center text-2xl">
                📦
            </div>
        </div>
    </div>

    <!-- Card 2b - Stok Tahu Kuning (Kuning) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Stok Tahu Kuning</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ number_format($stokKuning ?? 0) }}
                </p>
            </div>
            <div class="w-12 h-12 rounded-full bg-yellow-100 flex items-center justify-center text-2xl">
                📦
            </div>
        </div>
    </div>

    <!-- Card 3 - Pesanan (Oranye) -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 hover:shadow-md transition-shadow">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-medium text-gray-600">Total Pesanan</p>
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    {{ $totalPesanan }}
                </p>
                <!-- <p class="mt-1 text-sm text-orange-600 font-semibold">15 pending</p> -->
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
                <p class="mt-2 text-3xl font-bold text-gray-900">
                    Rp {{ number_format($totalPendapatan, 0, ',', '.') }}
                </p>
                <!-- <p class="mt-1 text-sm text-teal-600 font-semibold">+8% bulan ini</p> -->
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
                <option value="7"  {{ $range == 7 ? 'selected' : '' }}>7 Hari</option>
                <option value="30" {{ $range == 30 ? 'selected' : '' }}>30 Hari</option>
                <option value="90" {{ $range == 90 ? 'selected' : '' }}>90 Hari</option>
            </select>
        </div>
    </div>

    <div style="position: relative; height: 320px;">
        <canvas id="chartProduksi"></canvas>
    </div>
</div>

    <!-- Aktivitas -->
    <div class="bg-white p-6 rounded-lg shadow h-[400px] flex flex-col">
        <h2 class="font-semibold mb-4">Aktivitas Terbaru</h2>

        <ul class="space-y-4 text-sm overflow-y-auto pr-2 scrollbar-thin scrollbar-thumb-gray-300 scrollbar-track-gray-100">
            @forelse ($aktivitasTerbaru as $item)
                <li>
                    <p class="font-semibold">{{ $item->aktivitas }}</p>
                    <p class="text-gray-600 text-xs">
                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </p>
                </li>
            @empty
                <p class="text-gray-500 text-sm">Belum ada aktivitas.</p>
            @endforelse
        </ul>
    </div>

</div>

@endsection

@section('scripts')

<!-- h2canvas & jsPDF (untuk export PDF) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

<script>
    
    const chartLabels = {!! json_encode($labels) !!};
    const chartData   = {!! json_encode($dataProduksi) !!};

    const ctx = document.getElementById('chartProduksi');

    const chartProduksi = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: chartLabels,
            datasets: [{
                label: 'Total Produksi (unit)',
                backgroundColor: '#10B981',
                borderRadius: 8,
                barThickness: 30,
                data: chartData
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
    document.getElementById("rangeFilter").addEventListener("change", function () {
        const range = this.value;
        window.location.href = `?range=${range}`;
    });

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

