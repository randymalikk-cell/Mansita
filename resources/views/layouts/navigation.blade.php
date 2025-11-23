<nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom shadow-sm">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            @if (function_exists('auth') && Auth::user())
                {{ Auth::user()->name }}
            @else
                Dashboard
            @endif
        </a>

        <!-- Button Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="mainNavbar">

            <!-- Left Menu -->
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" 
                       href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>
            </ul>

            <!-- Right Menu -->
            <ul class="navbar-nav ms-auto">

                <!-- User Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" id="userMenu" role="button" 
                       data-bs-toggle="dropdown">
                        {{ Auth::user()->name }}
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">

                        <!-- Kalau mau aktifkan ini tinggal buat routenya -->
                        {{-- <li><a class="dropdown-item" href="#">Profile</a></li> --}}
                        
                        <li><hr class="dropdown-divider"></li>

                        <!-- Logout -->
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item text-danger" type="submit">
                                    Log Out
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>

    </div>
</nav>
