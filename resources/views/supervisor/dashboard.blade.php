@extends('layouts.app')

@section('title', 'Supervisor Dashboard')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard</h2>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Pending -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Trip Pending</p>
                            <h2 class="mb-0 fw-bold">{{ $totalPending }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('supervisor.trips.pending') }}" class="text-white text-decoration-none">
                            <small><i class="bi bi-arrow-right me-1"></i>Lihat Pengajuan</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total On Trip -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Sedang Perjalanan</p>
                            <h2 class="mb-0 fw-bold">{{ $totalOnTrip }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-geo-alt fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('supervisor.trips.all') }}" class="text-white text-decoration-none">
                            <small><i class="bi bi-arrow-right me-1"></i>Lihat Semua</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Completed -->
        <div class="col-md-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Trip Selesai</p>
                            <h2 class="mb-0 fw-bold">{{ $totalCompleted }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-check-circle fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('supervisor.trips.review') }}" class="text-white text-decoration-none">
                            <small><i class="bi bi-arrow-right me-1"></i>Review Perjalanan</small>
                        </a>
                    </div>
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
                                            <td><span class="badge bg-warning text-dark">Pending</span></td>
                                            <td class="text-center">
                                                <a href="{{ route('supervisor.trips.show', $trip) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>View
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
                                            <td><span class="badge bg-success">Completed</span></td>
                                            <td class="text-center">
                                                <a href="{{ route('supervisor.trips.show', $trip) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="bi bi-eye me-1"></i>View
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
@endsection
