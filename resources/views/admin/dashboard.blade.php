@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-speedometer2 me-2"></i>Dashboard Admin</h2>
    </div>

    <!-- Statistics Cards -->
    <div class="row g-4 mb-4">
        <!-- Total Kendaraan -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Kendaraan</p>
                            <h2 class="mb-0 fw-bold">{{ $totalVehicles }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-car-front fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.vehicles.index') }}" class="text-white text-decoration-none">
                            <small><i class="bi bi-arrow-right me-1"></i>Lihat Detail</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Perjalanan -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Perjalanan</p>
                            <h2 class="mb-0 fw-bold">{{ $totalTrips }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-geo-alt fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.trips.index') }}" class="text-white text-decoration-none">
                            <small><i class="bi bi-arrow-right me-1"></i>Lihat Detail</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Pengguna -->
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Total Pengguna</p>
                            <h2 class="mb-0 fw-bold">{{ $totalUsers }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-people fs-3"></i>
                        </div>
                    </div>
                    <div class="mt-3">
                        <a href="{{ route('admin.users.index') }}" class="text-white text-decoration-none">
                            <small><i class="bi bi-arrow-right me-1"></i>Lihat Detail</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Perjalanan Selesai -->
        <div class="col-md-6 col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Perjalanan Selesai</p>
                            <h2 class="mb-0 fw-bold">{{ $completedTrips }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-check-circle fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Menunggu Persetujuan -->
        <div class="col-md-6 col-lg-6">
            <div class="card border-0 shadow-sm h-100" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);">
                <div class="card-body text-white">
                    <div class="d-flex justify-content-between align-items-start">
                        <div>
                            <p class="mb-1 opacity-75">Menunggu Persetujuan</p>
                            <h2 class="mb-0 fw-bold">{{ $pendingTrips }}</h2>
                        </div>
                        <div class="bg-white bg-opacity-25 rounded p-3">
                            <i class="bi bi-clock-history fs-3"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h5 class="card-title mb-3"><i class="bi bi-lightning-charge me-2"></i>Aksi Cepat</h5>
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary w-100 py-3">
                                <i class="bi bi-plus-circle me-2"></i>Tambah Kendaraan
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.users.create') }}" class="btn btn-success w-100 py-3">
                                <i class="bi bi-person-plus me-2"></i>Tambah Pengguna
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.trips.index') }}" class="btn btn-info w-100 py-3">
                                <i class="bi bi-list-ul me-2"></i>Lihat Perjalanan
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="{{ route('admin.reports.trips') }}" class="btn btn-warning w-100 py-3">
                                <i class="bi bi-file-earmark-text me-2"></i>Laporan Rekap
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
