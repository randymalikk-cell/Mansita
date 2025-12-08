<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} - Mansita DB</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <!-- Animate CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    
    <!-- App CSS -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"
</head>

<body class="bg-gray-100">
    <div class="flex">
        <!-- SIDEBAR -->
        <aside class="w-64 h-screen bg-white shadow-md fixed">
            <div class="p-6 flex items-center gap-3 border-b">
                <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white text-xl font-bold">
                    M
                </div>
                <div>
                    <h2 class="font-semibold text-gray-900">Mansita DB</h2>
                    <p class="text-xs text-gray-500">Management System</p>
                </div>
            </div>

            <nav class="mt-4 space-y-1 px-3">
                @auth
                    @php
                        $user = auth()->user();
                    @endphp

                    <!-- Staf Produksi Menu -->
                    @if(auth()->user()->role === 'staf produksi')
                        <div class="border-t border-gray-200 my-2 pt-2">
                            <div class="px-6 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Staf Produksi
                            </div>
                        </div>
                        <a href="{{ route('staf-produksi.produksi.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('staf-produksi.produksi.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-gear me-2"></i> Input Produksi
                        </a>
                    @endif

                    <!-- Manajemen Menu (Admin & Pengurus) -->
                    @if(in_array(auth()->user()->role, ['pengurus']))
                        <a href="{{ route('manajemen.laporan.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('manajemen.laporan.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-file-text me-2"></i> Laporan
                        </a>
                    @endif

                    <!-- Admin Only Menu -->
                    @if(auth()->user()->role === 'admin')
                        <div class="border-t border-gray-200 my-2 pt-2">
                            <div class="px-6 py-2 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Administration
                            </div>
                        </div>

                        <!-- Dashboard -->
                        <a href="{{ route('dashboard') }}" 
                        class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-house-door me-2"></i> Dashboard
                        </a>

                        <a href="{{ route('manajemen.stok.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('manajemen.stok.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-box-seam me-2"></i> Manajemen Stok
                        </a>

                        <a href="{{ route('manajemen.transaksi.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('manajemen.transaksi.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-receipt me-2"></i> Transaksi
                        </a>

                        <a href="{{ route('admin.users.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-people me-2"></i> Manajemen Pengguna
                        </a>

                        <a href="{{ route('admin.pelanggan.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('admin.pelanggan.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-person-badge me-2"></i> Manajemen Pelanggan
                        </a>

                        <a href="{{ route('manajemen.laporan.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('manajemen.laporan.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-file-text me-2"></i> Laporan
                        </a>

                        <a href="{{ route('admin.log_aktivitas.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('admin.log_aktivitas.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-clock-history me-2"></i> Log Aktivitas
                        </a>

                        <a href="{{ route('admin.backup.index') }}" 
                           class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('admin.backup.*') ? 'active' : 'text-gray-700' }}">
                            <i class="bi bi-cloud-check me-2"></i> Backup & Restore
                        </a>
                    @endif
                @endauth
            </nav>

            <!-- Logout Button -->
            @auth
                <div class="absolute bottom-6 left-0 right-0 px-3">
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link block w-full px-6 py-3 rounded-lg text-gray-700 text-left hover:bg-red-50 hover:text-red-600">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </button>
                    </form>
                </div>
            @endauth
        </aside>

        <!-- MAIN CONTENT -->
        <main class="ml-64 w-full p-6 pb-20">
            {{ $slot ?? '' }}
            @yield('content')
        </main>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- App JS -->
    <script src="{{ asset('js/app.js') }}"></script>

    @yield('scripts')
</body>
</html>