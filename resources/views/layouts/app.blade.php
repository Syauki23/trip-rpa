<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Perjalanan')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom Modern CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <!-- Mobile App Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    
    @stack('styles')
</head>
<body>
    @auth
    <!-- Desktop Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light desktop-only">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <i class="bi bi-truck-front"></i> Sistem Perjalanan
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    @if(auth()->user()->role->name === 'admin')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                               href="{{ route('admin.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dasbor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}" 
                               href="{{ route('admin.vehicles.index') }}">
                                <i class="bi bi-car-front"></i> Kendaraan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.trips.*') ? 'active' : '' }}" 
                               href="{{ route('admin.trips.index') }}">
                                <i class="bi bi-list-ul"></i> Perjalanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" 
                               href="{{ route('admin.users.index') }}">
                                <i class="bi bi-people"></i> Manajemen Akun
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}" 
                               href="{{ route('admin.reports.trips') }}">
                                <i class="bi bi-file-earmark-text"></i> Laporan Rekap Perjalanan
                            </a>
                        </li>
                    @elseif(auth()->user()->role->name === 'supervisor')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}" 
                               href="{{ route('supervisor.dashboard') }}">
                                <i class="bi bi-speedometer2"></i> Dasbor
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('supervisor.trips.pending') ? 'active' : '' }}" 
                               href="{{ route('supervisor.trips.pending') }}">
                                <i class="bi bi-inbox"></i> Pengajuan Masuk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('supervisor.trips.all') ? 'active' : '' }}" 
                               href="{{ route('supervisor.trips.all') }}">
                                <i class="bi bi-list-ul"></i> Semua Perjalanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('supervisor.trips.review') ? 'active' : '' }}" 
                               href="{{ route('supervisor.trips.review') }}">
                                <i class="bi bi-check-circle"></i> Selesai & Review
                            </a>
                        </li>
                    @elseif(auth()->user()->role->name === 'driver')
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('driver.trips.index') ? 'active' : '' }}" 
                               href="{{ route('driver.trips.index') }}">
                                <i class="bi bi-list-ul"></i> Perjalanan Saya
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('driver.trips.create') ? 'active' : '' }}" 
                               href="{{ route('driver.trips.create') }}">
                                <i class="bi bi-plus-circle"></i> Buat Perjalanan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('driver.trips.history') ? 'active' : '' }}" 
                               href="{{ route('driver.trips.history') }}">
                                <i class="bi bi-clock-history"></i> Riwayat
                            </a>
                        </li>
                    @endif
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> {{ auth()->user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <span class="dropdown-item-text">
                                    <small class="text-muted">{{ ucfirst(auth()->user()->role->name) }}</small>
                                </span>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="bi bi-box-arrow-right"></i> Keluar
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    
    <!-- Mobile Header -->
    <div class="mobile-header mobile-only">
        <div class="d-flex align-items-center gap-3">
            <i class="bi bi-truck-front"></i>
            <h1>Sistem Perjalanan</h1>
        </div>
        <div class="header-actions">
            <button class="btn" onclick="window.location.reload()">
                <i class="bi bi-arrow-clockwise"></i>
            </button>
        </div>
    </div>
    @endauth

    <main class="main-content" style="min-height: calc(100vh - 140px); padding: 24px 0;">
        <div class="container-fluid px-4">
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    @auth
    <!-- Mobile Bottom Navigation -->
    <nav class="bottom-nav mobile-only">
        @if(auth()->user()->role->name === 'driver')
            <a href="{{ route('driver.trips.index') }}" 
               class="bottom-nav-item {{ request()->routeIs('driver.trips.index') ? 'active' : '' }}">
                <i class="bi bi-house-door-fill"></i>
                <span>Beranda</span>
            </a>
            <a href="{{ route('driver.trips.create') }}" 
               class="bottom-nav-item {{ request()->routeIs('driver.trips.create') ? 'active' : '' }}">
                <i class="bi bi-plus-circle-fill"></i>
                <span>Buat</span>
            </a>
            <a href="{{ route('driver.trips.history') }}" 
               class="bottom-nav-item {{ request()->routeIs('driver.trips.history') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i>
                <span>Riwayat</span>
            </a>
            <a href="#" class="bottom-nav-item" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                <i class="bi bi-person-circle"></i>
                <span>Log Out</span>
            </a>
        @elseif(auth()->user()->role->name === 'supervisor')
            <a href="{{ route('supervisor.dashboard') }}" 
               class="bottom-nav-item {{ request()->routeIs('supervisor.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dasbor</span>
            </a>
            <a href="{{ route('supervisor.trips.pending') }}" 
               class="bottom-nav-item {{ request()->routeIs('supervisor.trips.pending') ? 'active' : '' }}">
                <i class="bi bi-inbox-fill"></i>
                <span>Pengajuan</span>
            </a>
            <a href="{{ route('supervisor.trips.all') }}" 
               class="bottom-nav-item {{ request()->routeIs('supervisor.trips.all') ? 'active' : '' }}">
                <i class="bi bi-list-ul"></i>
                <span>Semua</span>
            </a>
            <a href="#" class="bottom-nav-item" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();">
                <i class="bi bi-person-circle"></i>
                <span>Log Out</span>
            </a>
        @elseif(auth()->user()->role->name === 'admin')
            <a href="{{ route('admin.dashboard') }}" 
               class="bottom-nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i>
                <span>Dasbor</span>
            </a>
            <a href="{{ route('admin.vehicles.index') }}" 
               class="bottom-nav-item {{ request()->routeIs('admin.vehicles.*') ? 'active' : '' }}">
                <i class="bi bi-car-front-fill"></i>
                <span>Kendaraan</span>
            </a>
            <a href="{{ route('admin.trips.index') }}" 
               class="bottom-nav-item {{ request()->routeIs('admin.trips.*') ? 'active' : '' }}">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Perjalanan</span>
            </a>
            <a href="{{ route('admin.users.index') }}" 
               class="bottom-nav-item {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                <i class="bi bi-people-fill"></i>
                <span>Pengguna</span>
            </a>
        @endif
    </nav>
    
    <!-- Hidden logout form for mobile -->
    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
    @endauth

    <footer class="bg-white border-top py-4 mt-auto desktop-only">
        <div class="container-fluid px-4 text-center">
            <small class="text-muted">
                <i class="bi bi-c-circle me-1"></i>{{ date('Y') }} Sistem Perjalanan. Hak cipta dilindungi.
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
