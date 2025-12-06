<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Dashboard' }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"
    />
    <style>
        .nav-link {
            transition: all 0.2s ease;
        }
        
        .nav-link.active {
            background: #D1FAE5;
            color: #16A34A;
            font-weight: 600;
            border-left: 4px solid #16A34A;
        }
        
        .nav-link:not(.active):hover {
            background: #F3F4F6;
        }
    </style>
</head>

<body class="bg-gray-100">

<div class="flex">

    <!-- SIDEBAR -->
    <aside class="w-70 h-screen bg-white shadow-md fixed">
        <div class="p-6 flex items-center gap-3 border-b">
            <div class="w-10 h-10 bg-green-600 rounded-lg flex items-center justify-center text-white text-xl font-bold">
                T
            </div>
            <div>
                <h2 class="font-semibold">Tahu ADR</h2>
                <p class="text-xs text-gray-500">Management System</p>
            </div>
        </div>

        <nav class="mt-4 space-y-1 px-3">
            <a href="{{ route('dashboard') }}" 
               class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'active' : 'text-gray-700' }}">
                <i class="bi bi-house-door me-2"></i> Dashboard
            </a>
            
            <a href="{{ route('admin.users.index') }}" 
               class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('admin.users.*') ? 'active' : 'text-gray-700' }}">
                <i class="bi bi-people me-2"></i> Manajemen Pengguna
            </a>
            
            <a href="{{ route('manajemen.stok.index') }}" 
               class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('manajemen.stok.*') || request()->routeIs('stok.*') ? 'active' : 'text-gray-700' }}">
                <i class="bi bi-box-seam me-2"></i> Manajemen Stok
            </a>
            
            <a href="" 
               class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('pelanggan.*') ? 'active' : 'text-gray-700' }}">
                <i class="bi bi-person-badge me-2"></i> Manajemen Pelanggan
            </a>
            
            <a href="" 
               class="nav-link block px-6 py-3 rounded-lg {{ request()->routeIs('laporan.*') ? 'active' : 'text-gray-700' }}">
                <i class="bi bi-file-text me-2"></i> Laporan
            </a>
        </nav>

        <!-- Logout Button (Optional) -->
        <div class="absolute bottom-6 left-0 right-0 px-3">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="nav-link block w-full px-6 py-3 rounded-lg text-gray-700 text-left hover:bg-red-50 hover:text-red-600">
                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>


    <!-- MAIN CONTENT -->
    <main class="ml-64 w-full p-6">
        @yield('content')
    </main>

    
</div>

@yield('scripts')

</body>
</html>