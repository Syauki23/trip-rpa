@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="mb-1 fw-bold"><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard Admin</h2>
            <p class="text-muted mb-0">Selamat datang kembali, {{ auth()->user()->name }}</p>
        </div>
        <div class="text-end">
            <small class="text-muted d-block">{{ now()->format('l, d F Y') }}</small>
            <small class="text-muted">{{ now()->format('H:i') }} WIB</small>
        </div>
    </div>

    <!-- Quick Stats Row -->
    <div class="row g-4 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-primary bg-opacity-10 text-primary">
                            <i class="bi bi-car-front"></i>
                        </div>
                        <span class="badge bg-primary bg-opacity-10 text-primary">Total</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalVehicles }}</h3>
                    <p class="text-muted mb-0 small">Kendaraan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-success bg-opacity-10 text-success">
                            <i class="bi bi-geo-alt"></i>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success">Total</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalTrips }}</h3>
                    <p class="text-muted mb-0 small">Perjalanan</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-info bg-opacity-10 text-info">
                            <i class="bi bi-people"></i>
                        </div>
                        <span class="badge bg-info bg-opacity-10 text-info">Total</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $totalUsers }}</h3>
                    <p class="text-muted mb-0 small">Pengguna</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 h-100 stat-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div class="stat-icon bg-warning bg-opacity-10 text-warning">
                            <i class="bi bi-clock-history"></i>
                        </div>
                        <span class="badge bg-warning bg-opacity-10 text-warning">Pending</span>
                    </div>
                    <h3 class="fw-bold mb-1">{{ $pendingTrips }}</h3>
                    <p class="text-muted mb-0 small">Menunggu</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Charts Row -->
    <div class="row g-4 mb-4">
        <!-- Area Chart - Perjalanan 7 Hari Terakhir -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Perjalanan 7 Hari Terakhir</h5>
                            <p class="text-muted mb-0 small">Tren perjalanan mingguan</p>
                        </div>
                        <div class="chart-icon">
                            <i class="bi bi-graph-up text-primary"></i>
                        </div>
                    </div>
                    <canvas id="tripsAreaChart" height="80"></canvas>
                </div>
            </div>
        </div>

        <!-- Donut Chart - Status Perjalanan -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Status Perjalanan</h5>
                            <p class="text-muted mb-0 small">Distribusi status</p>
                        </div>
                        <div class="chart-icon">
                            <i class="bi bi-pie-chart text-success"></i>
                        </div>
                    </div>
                    <canvas id="statusDonutChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bar Chart & Quick Actions -->
    <div class="row g-4">
        <!-- Bar Chart - Pengguna per Role -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div>
                            <h5 class="fw-bold mb-1">Pengguna Berdasarkan Role</h5>
                            <p class="text-muted mb-0 small">Distribusi pengguna</p>
                        </div>
                        <div class="chart-icon">
                            <i class="bi bi-bar-chart text-info"></i>
                        </div>
                    </div>
                    <canvas id="usersBarChart" height="120"></canvas>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-body p-4">
                    <div class="mb-4">
                        <h5 class="fw-bold mb-1">Aksi Cepat</h5>
                        <p class="text-muted mb-0 small">Shortcut menu utama</p>
                    </div>
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-outline-primary w-100 py-3 rounded-3 quick-action-btn">
                                <i class="bi bi-plus-circle fs-4 d-block mb-2"></i>
                                <span class="small">Tambah Kendaraan</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-outline-success w-100 py-3 rounded-3 quick-action-btn">
                                <i class="bi bi-person-plus fs-4 d-block mb-2"></i>
                                <span class="small">Tambah Pengguna</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.trips.index') }}" class="btn btn-outline-info w-100 py-3 rounded-3 quick-action-btn">
                                <i class="bi bi-list-ul fs-4 d-block mb-2"></i>
                                <span class="small">Lihat Perjalanan</span>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('admin.reports.trips') }}" class="btn btn-outline-warning w-100 py-3 rounded-3 quick-action-btn">
                                <i class="bi bi-file-earmark-text fs-4 d-block mb-2"></i>
                                <span class="small">Laporan Rekap</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .stat-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.1) !important;
    }
    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }
    .chart-icon {
        width: 40px;
        height: 40px;
        background: rgba(var(--bs-primary-rgb), 0.1);
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.25rem;
    }
    .quick-action-btn {
        transition: all 0.2s ease;
        border-width: 2px;
    }
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.25rem 0.75rem rgba(0, 0, 0, 0.1);
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
    // Chart.js Global Configuration
    Chart.defaults.font.family = "'Inter', sans-serif";
    Chart.defaults.color = '#6c757d';

    // Area Chart - Perjalanan 7 Hari Terakhir
    const areaCtx = document.getElementById('tripsAreaChart').getContext('2d');
    const areaGradient = areaCtx.createLinearGradient(0, 0, 0, 300);
    areaGradient.addColorStop(0, 'rgba(13, 110, 253, 0.3)');
    areaGradient.addColorStop(1, 'rgba(13, 110, 253, 0.01)');

    new Chart(areaCtx, {
        type: 'line',
        data: {
            labels: ['6 hari lalu', '5 hari lalu', '4 hari lalu', '3 hari lalu', '2 hari lalu', 'Kemarin', 'Hari ini'],
            datasets: [{
                label: 'Perjalanan',
                data: [12, 19, 15, 25, 22, 30, 28],
                backgroundColor: areaGradient,
                borderColor: '#0d6efd',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0d6efd',
                pointBorderWidth: 2,
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#6c757d',
                    borderColor: '#dee2e6',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' perjalanan';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f8f9fa',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            }
        }
    });

    // Donut Chart - Status Perjalanan
    const donutCtx = document.getElementById('statusDonutChart').getContext('2d');
    new Chart(donutCtx, {
        type: 'doughnut',
        data: {
            labels: ['Pending', 'Berjalan', 'Selesai'],
            datasets: [{
                data: [{{ $pendingTrips }}, {{ $totalTrips - $completedTrips - $pendingTrips }}, {{ $completedTrips }}],
                backgroundColor: [
                    '#ffc107',
                    '#0dcaf0',
                    '#198754'
                ],
                borderWidth: 0,
                hoverOffset: 10
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        pointStyle: 'circle',
                        font: {
                            size: 12
                        }
                    }
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#6c757d',
                    borderColor: '#dee2e6',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: true,
                    callbacks: {
                        label: function(context) {
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((context.parsed / total) * 100).toFixed(1);
                            return context.label + ': ' + context.parsed + ' (' + percentage + '%)';
                        }
                    }
                }
            },
            cutout: '70%'
        }
    });

    // Bar Chart - Pengguna per Role
    const barCtx = document.getElementById('usersBarChart').getContext('2d');
    new Chart(barCtx, {
        type: 'bar',
        data: {
            labels: ['Admin', 'Supervisor', 'Driver'],
            datasets: [{
                label: 'Jumlah Pengguna',
                data: [3, 5, 15], // Ganti dengan data real dari controller
                backgroundColor: [
                    'rgba(220, 53, 69, 0.8)',
                    'rgba(255, 193, 7, 0.8)',
                    'rgba(13, 202, 240, 0.8)'
                ],
                borderColor: [
                    '#dc3545',
                    '#ffc107',
                    '#0dcaf0'
                ],
                borderWidth: 2,
                borderRadius: 8,
                borderSkipped: false
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: true,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#fff',
                    titleColor: '#000',
                    bodyColor: '#6c757d',
                    borderColor: '#dee2e6',
                    borderWidth: 1,
                    padding: 12,
                    displayColors: false,
                    callbacks: {
                        label: function(context) {
                            return context.parsed.y + ' pengguna';
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#f8f9fa',
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10,
                        stepSize: 5
                    }
                },
                x: {
                    grid: {
                        display: false,
                        drawBorder: false
                    },
                    ticks: {
                        padding: 10
                    }
                }
            }
        }
    });
</script>
@endpush
