@extends('layouts.app')

@section('title', 'Laporan Rekap Perjalanan')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Laporan Rekap Perjalanan</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    <!-- Filter Form -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Laporan</h5>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('admin.reports.trips') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label for="vehicle_id" class="form-label">Kendaraan</label>
                        <select class="form-select" id="vehicle_id" name="vehicle_id">
                            <option value="">-- Semua Kendaraan --</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->name }} - {{ $vehicle->plate_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" 
                               value="{{ request('start_date') }}">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" 
                               value="{{ request('end_date') }}">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>Filter
                        </button>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-12">
                        <a href="{{ route('admin.reports.trips') }}" class="btn btn-outline-secondary">
                            <i class="bi bi-x-circle me-2"></i>Reset Filter
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Export Buttons -->
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.reports.trips.export-excel', request()->all()) }}" 
                   class="btn btn-success">
                    <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
                </a>
                <a href="{{ route('admin.reports.trips.export-pdf', request()->all()) }}" 
                   class="btn btn-danger">
                    <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Data Table -->
    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($trips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Driver</th>
                                <th>Kendaraan</th>
                                <th>Tujuan</th>
                                <th>KM Awal</th>
                                <th>KM Akhir</th>
                                <th>Total KM</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                                <tr>
                                    <td><span class="badge bg-secondary">#{{ $trip->id }}</span></td>
                                    <td>{{ $trip->driver->name ?? '-' }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $trip->vehicle->name ?? '-' }}</div>
                                        <small class="text-muted">{{ $trip->vehicle->plate_number ?? '-' }}</small>
                                    </td>
                                    <td>{{ $trip->tujuan }}</td>
                                    <td>{{ $trip->km_awal ? number_format($trip->km_awal) . ' km' : '-' }}</td>
                                    <td>{{ $trip->km_akhir ? number_format($trip->km_akhir) . ' km' : '-' }}</td>
                                    <td>
                                        @if($trip->total_km)
                                            <strong class="text-success">{{ number_format($trip->total_km) }} km</strong>
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $trip->created_at->format('d M Y') }}</td>
                                    <td>
                                        @if($trip->status === 'pending')
                                            <span class="badge bg-warning text-dark">Pending</span>
                                        @elseif($trip->status === 'approved')
                                            <span class="badge bg-info">Approved</span>
                                        @elseif($trip->status === 'ongoing')
                                            <span class="badge bg-primary">Ongoing</span>
                                        @elseif($trip->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($trip->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.trips.show', $trip) }}" 
                                           class="btn btn-sm btn-outline-primary">
                                            <i class="bi bi-eye me-1"></i>View
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-3">
                    {{ $trips->appends(request()->query())->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">
                        @if(request()->hasAny(['vehicle_id', 'start_date', 'end_date']))
                            Tidak ada data perjalanan untuk filter yang dipilih.
                        @else
                            Belum ada data perjalanan.
                        @endif
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
