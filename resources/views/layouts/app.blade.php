<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-64 h-screen bg-white shadow-md fixed">
        <div class="p-6 flex items-center gap-3 border-b">
            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white text-xl font-bold">
                T
            </div>
            <div>
                <h2 class="font-semibold">Tahu ADR</h2>
                <p class="text-xs text-gray-500">Management System</p>
            </div>
        </div>

        <nav class="mt-4 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-6 py-3 bg-green-50 text-green-600 font-semibold">
                Dashboard
            </a>
            <a class="block px-6 py-3 hover:bg-gray-100">Manajemen Pengguna</a>
            <a class="block px-6 py-3 hover:bg-gray-100" href="{{ route('manajemen.stok.index') }}">Manajemen Stok</a>
            <a class="block px-6 py-3 hover:bg-gray-100">Manajemen Pelanggan</a>
            <a class="block px-6 py-3 hover:bg-gray-100">Laporan</a>
        </nav>
    </aside>


    <!-- MAIN CONTENT -->
    <main class="ml-64 w-full p-6">
        @yield('content')
    </main>

    
</div>

@yield('scripts')

</body>
</html>
