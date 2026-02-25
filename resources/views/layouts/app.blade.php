<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'PT RPA')</title>
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom Modern CSS -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <!-- Mobile App Style CSS -->
    <link rel="stylesheet" href="{{ asset('css/mobile.css') }}">
    
    <!-- Dark Mode CSS -->
    <link rel="stylesheet" href="{{ asset('css/darkmode.css') }}">
    
    @stack('styles')
</head>
<body class="light-mode" id="themeBody">
    @auth
    <!-- Desktop Navbar -->
    <nav class="navbar navbar-expand-lg navbar-light desktop-only">
        <div class="container-fluid px-4">
            <a class="navbar-brand" href="#">
                <i class="bi bi-truck-front"></i> PT RPA
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
                    <li class="nav-item">
                        <button class="theme-toggle-btn" onclick="toggleTheme()" title="Toggle Dark Mode">
                            <i class="bi bi-moon-fill" id="themeIcon"></i>
                        </button>
                    </li>
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
            <h1>PT RPA</h1>
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
            <button class="bottom-nav-item" onclick="toggleAccountMenu(event)" type="button">
                <i class="bi bi-person-circle"></i>
                <span>Akun</span>
            </button>
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
            <a href="{{ route('supervisor.trips.review') }}" 
                class="bottom-nav-item {{ request()->routeIs('supervisor.trips.review') ? 'active' : '' }}">
                <i class="bi bi-check2-circle"></i>
                <span>Review</span>
            </a>
            <button class="bottom-nav-item" onclick="toggleAccountMenu(event)" type="button">
                <i class="bi bi-person-circle"></i>
                <span>Akun</span>
            </button>
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
            <button class="bottom-nav-item" onclick="toggleAccountMenu(event)" type="button">
                <i class="bi bi-person-circle"></i>
                <span>Akun</span>
            </button>
        @endif
    </nav>
    
    <!-- Mobile Account Menu Popup -->
    <div id="accountMenuPopup" class="account-menu-popup" style="display: none;">
        <div class="account-menu-header">
            <div class="account-menu-name">{{ auth()->user()->name }}</div>
            <div class="account-menu-email">{{ auth()->user()->email }}</div>
        </div>
        <div class="account-menu-body">
            <button class="account-menu-item" onclick="toggleTheme()" type="button">
                <div class="item-content">
                    <i class="bi bi-moon-stars-fill" id="themeIconMobile"></i>
                    <span>Ubah Tema</span>
                </div>
                <span class="theme-status" id="themeStatusMobile">Light</span>
            </button>
            <button class="account-menu-item" onclick="alert('Fitur Profil akan segera hadir')" type="button">
                <div class="item-content">
                    <i class="bi bi-person-fill"></i>
                    <span>Profil</span>
                </div>
            </button>
            <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                @csrf
                <button type="submit" class="account-menu-item">
                    <div class="item-content">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Log Out</span>
                    </div>
                </button>
            </form>
        </div>
    </div>
    
    <!-- Popup Overlay -->
    <div id="popupOverlay" class="popup-overlay" onclick="closeAccountMenu()" style="display: none;"></div>
    @endauth

    <footer class="bg-white border-top py-4 mt-auto desktop-only">
        <div class="container-fluid px-4 text-center">
            <small class="text-muted">
                <i class="bi bi-c-circle me-1"></i>{{ date('Y') }} PT RPA . Hak cipta dilindungi.
            </small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Dark Mode Theme Toggle Script -->
    <script>
        // Apply theme function
        function applyTheme(theme) {
            const body = document.getElementById('themeBody');
            if (body) {
                body.className = theme;
            }
            updateThemeIcons(theme);
        }
        
        // Load theme from localStorage on page load
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light-mode';
            applyTheme(savedTheme);
        })();
        
        // Toggle theme function
        function toggleTheme() {
            const body = document.getElementById('themeBody');
            const currentTheme = body.className;
            const newTheme = currentTheme === 'light-mode' ? 'dark-mode' : 'light-mode';
            
            // Apply new theme with smooth transition
            applyTheme(newTheme);
            
            // Save to localStorage
            localStorage.setItem('theme', newTheme);
            
            // Add subtle animation feedback
            body.style.transition = 'background-color 0.25s ease, color 0.25s ease';
        }
        
        // Update theme icons
        function updateThemeIcons(theme) {
            const themeIcon = document.getElementById('themeIcon');
            const themeIconMobile = document.getElementById('themeIconMobile');
            const themeStatusMobile = document.getElementById('themeStatusMobile');
            
            if (theme === 'dark-mode') {
                if (themeIcon) {
                    themeIcon.className = 'bi bi-sun-fill';
                }
                if (themeIconMobile) {
                    themeIconMobile.className = 'bi bi-sun-fill';
                }
                if (themeStatusMobile) {
                    themeStatusMobile.textContent = 'Dark';
                }
            } else {
                if (themeIcon) {
                    themeIcon.className = 'bi bi-moon-fill';
                }
                if (themeIconMobile) {
                    themeIconMobile.className = 'bi bi-moon-stars-fill';
                }
                if (themeStatusMobile) {
                    themeStatusMobile.textContent = 'Light';
                }
            }
        }
        
        // Toggle account menu popup (mobile)
        function toggleAccountMenu(event) {
            event.stopPropagation();
            const popup = document.getElementById('accountMenuPopup');
            const overlay = document.getElementById('popupOverlay');
            
            if (popup && overlay) {
                const isVisible = popup.style.display === 'block';
                
                if (isVisible) {
                    closeAccountMenu();
                } else {
                    popup.style.display = 'block';
                    overlay.style.display = 'block';
                }
            }
        }
        
        // Close account menu
        function closeAccountMenu() {
            const popup = document.getElementById('accountMenuPopup');
            const overlay = document.getElementById('popupOverlay');
            
            if (popup && overlay) {
                popup.style.display = 'none';
                overlay.style.display = 'none';
            }
        }
        
        // Close popup when clicking outside
        document.addEventListener('DOMContentLoaded', function() {
            const overlay = document.getElementById('popupOverlay');
            if (overlay) {
                overlay.addEventListener('click', function() {
                    closeAccountMenu();
                });
            }
            
            // Close popup when clicking anywhere on the page except the popup itself
            document.addEventListener('click', function(event) {
                const popup = document.getElementById('accountMenuPopup');
                const accountButton = event.target.closest('.bottom-nav-item');
                
                if (popup && popup.style.display === 'block') {
                    // Check if click is outside popup and not on account button
                    if (!popup.contains(event.target) && !accountButton) {
                        closeAccountMenu();
                    }
                }
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html>
