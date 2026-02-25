@extends('layouts.app')

@section('title', 'Dashboard Supervisor')

@section('content')
<style>
/* Premium Stat Cards */
.premium-stat-card {
    border-radius: 16px;
    transition: all 0.3s ease;
    background: #fff;
    overflow: hidden;
    position: relative;
}

.premium-stat-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
}

.premium-stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
}

/* Icon Containers with Glassmorphism */
.icon-container-warning,
.icon-container-info,
.icon-container-success {
    width: 60px;
    height: 60px;
    border-radius: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
}

.icon-container-warning {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
    border: 1px solid rgba(255, 193, 7, 0.2);
}

.icon-container-info {
    background: rgba(13, 202, 240, 0.1);
    color: #0dcaf0;
    border: 1px solid rgba(13, 202, 240, 0.2);
}

.icon-container-success {
    background: rgba(25, 135, 84, 0.1);
    color: #198754;
    border: 1px solid rgba(25, 135, 84, 0.2);
}

/* Mini Chart Container */
.mini-chart-container {
    height: 60px;
    position: relative;
    background: rgba(0,0,0,0.02);
    border-radius: 8px;
    padding: 4px;
}

/* Button Styling */
.premium-stat-card .btn {
    border-radius: 8px;
    font-weight: 500;
    transition: all 0.2s ease;
}

.premium-stat-card .btn:hover {
    transform: scale(1.02);
}

/* Typography */
.premium-stat-card h2 {
    font-size: 2.5rem;
    line-height: 1;
}

.premium-stat-card .small {
    font-size: 0.75rem;
    letter-spacing: 0.5px;
    text-transform: uppercase;
}
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard Supervisor</h2>
    </div>

    <!-- Statistics Cards with Mini Charts -->
    <div class="row g-4 mb-4">
        <!-- Pending Card -->
        <div class="col-md-4">
            <div class="card premium-stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">PERJALANAN PENDING</p>
                            <h2 class="mb-0 fw-bold text-warning">{{ $totalPending }}</h2>
                            <small class="text-muted">Menunggu Persetujuan</small>
                        </div>
                        <div class="icon-container-warning">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                    </div>
                    <div class="mini-chart-container mb-3">
                        <canvas id="pendingSparkline" height="60"></canvas>
                    </div>
                    <a href="{{ route('supervisor.trips.pending') }}" class="btn btn-sm btn-outline-warning w-100">
                        <i class="bi bi-arrow-right me-1"></i>Lihat Pengajuan
                    </a>
                </div>
            </div>
        </div>

        <!-- Ongoing Card -->
        <div class="col-md-4">
            <div class="card premium-stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">SEDANG PERJALANAN</p>
                            <h2 class="mb-0 fw-bold text-info">{{ $totalOnTrip }}</h2>
                            <small class="text-muted">Dalam Perjalanan</small>
                        </div>
                        <div class="icon-container-info">
                            <i class="bi bi-geo-alt fs-3"></i>
                        </div>
                    </div>
                    <div class="mini-chart-container mb-3">
                        <canvas id="ongoingSparkline" height="60"></canvas>
                    </div>
                    <a href="{{ route('supervisor.trips.all') }}" class="btn btn-sm btn-outline-info w-100">
                        <i class="bi bi-arrow-right me-1"></i>Lihat Semua
                    </a>
                </div>
            </div>
        </div>

        <!-- Completed Card -->
        <div class="col-md-4">
            <div class="card premium-stat-card border-0 shadow-sm h-100">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <div>
                            <p class="text-muted mb-1 small fw-medium">PERJALANAN SELESAI</p>
                            <h2 class="mb-0 fw-bold text-success">{{ $totalCompleted }}</h2>
                            <small class="text-muted">Telah Diselesaikan</small>
                        </div>
                        <div class="icon-container-success">
                            <i class="bi bi-check-circle fs-3"></i>
                        </div>
                    </div>
                    <div class="mini-chart-container mb-3">
                        <canvas id="completedSparkline" height="60"></canvas>
                    </div>
                    <a href="{{ route('supervisor.trips.review') }}" class="btn btn-sm btn-outline-success w-100">
                        <i class="bi bi-arrow-right me-1"></i>Review Perjalanan
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Submissions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-inbox me-2"></i>5 Pengajuan Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentSubmissions->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Driver</th>
                                        <th>Kendaraan</th>
                                        <th>Tujuan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentSubmissions as $trip)
                                        <tr>
                                            <td><span class="badge bg-secondary">#{{ $trip->id }}</span></td>
                                            <td>{{ $trip->driver->name ?? '-' }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $trip->vehicle->name ?? '-' }}</div>
                                                <small class="text-muted">{{ $trip->vehicle->plate_number ?? '-' }}</small>
                                            </td>
                                            <td>{{ $trip->tujuan }}</td>
                                            <td>{{ $trip->created_at->format('d M Y') }}</td>
                                            <td><span class="badge bg-warning text-dark">Menunggu</span></td>
                                            <td class="text-center">
                                                <a href="{{ route('supervisor.trips.show', $trip) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Tidak ada pengajuan pending</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Completed -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-check-circle me-2"></i>5 Perjalanan Selesai Terbaru</h5>
                </div>
                <div class="card-body">
                    @if($recentCompleted->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>ID</th>
                                        <th>Driver</th>
                                        <th>Kendaraan</th>
                                        <th>Tujuan</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                        <th class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentCompleted as $trip)
                                        <tr>
                                            <td><span class="badge bg-secondary">#{{ $trip->id }}</span></td>
                                            <td>{{ $trip->driver->name ?? '-' }}</td>
                                            <td>
                                                <div class="fw-semibold">{{ $trip->vehicle->name ?? '-' }}</div>
                                                <small class="text-muted">{{ $trip->vehicle->plate_number ?? '-' }}</small>
                                            </td>
                                            <td>{{ $trip->tujuan }}</td>
                                            <td>{{ $trip->updated_at->format('d M Y') }}</td>
                                            <td><span class="badge bg-success">Selesai</span></td>
                                            <td class="text-center">
                                                <a href="{{ route('supervisor.trips.show', $trip) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>Lihat
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="bi bi-inbox fs-1 text-muted"></i>
                            <p class="text-muted mt-2">Belum ada perjalanan selesai</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Data untuk sparklines (7 hari terakhir)
    const sparklineData = @json($dataMingguan ?? []);
const sparkline = sparklineData.length ? sparklineData : [0,0,0,0,0,0,0];
    
    // Konfigurasi umum untuk sparklines
    const sparklineConfig = {
        type: 'line',
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: { enabled: false }
            },
            scales: {
                x: { display: false },
                y: { display: false }
            },
            elements: {
                point: { radius: 0 },
                line: { borderWidth: 2, tension: 0.4 }
            }
        }
    };
    
    // 1. Pending Sparkline (Warning - Yellow)
    const pendingCanvas = document.getElementById('pendingSparkline');
    if (pendingCanvas) {
        new Chart(pendingCanvas, {
            ...sparklineConfig,
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: sparklineData,
                    borderColor: '#ffc107',
                    backgroundColor: 'rgba(255, 193, 7, 0.1)',
                    fill: true
                }]
            }
        });
    }
    
    // 2. Ongoing Sparkline (Info - Cyan)
    const ongoingCanvas = document.getElementById('ongoingSparkline');
    if (ongoingCanvas) {
        new Chart(ongoingCanvas, {
            ...sparklineConfig,
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: sparklineData.map(v => Math.max(0, v - Math.floor(Math.random() * 3))),
                    borderColor: '#0dcaf0',
                    backgroundColor: 'rgba(13, 202, 240, 0.1)',
                    fill: true
                }]
            }
        });
    }
    
    // 3. Completed Sparkline (Success - Green)
    const completedCanvas = document.getElementById('completedSparkline');
    if (completedCanvas) {
        new Chart(completedCanvas, {
            ...sparklineConfig,
            data: {
                labels: ['', '', '', '', '', '', ''],
                datasets: [{
                    data: sparklineData.map(v => Math.max(0, v + Math.floor(Math.random() * 2))),
                    borderColor: '#198754',
                    backgroundColor: 'rgba(25, 135, 84, 0.1)',
                    fill: true
                }]
            }
        });
    }
});
</script>
@endsection
