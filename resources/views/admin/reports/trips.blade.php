@extends('layouts.app')

@section('title', 'Laporan Rekap Perjalanan')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-file-earmark-text me-2"></i>Laporan Rekap Perjalanan</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    {{-- FILTER FORM --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-funnel me-2"></i>Filter Laporan</h5>
        </div>
        <div class="card-body">

            <form method="GET" action="{{ route('admin.reports.trips') }}" id="filterForm">
                <div class="row g-3">

                    <div class="col-md-4">
                        <label class="form-label">Kendaraan</label>
                        <select class="form-select" name="vehicle_id">
                            <option value="">-- Semua Kendaraan --</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}"
                                    {{ request('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
                                    {{ $vehicle->name }} - {{ $vehicle->plate_number }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tanggal Awal</label>
                        <input type="date" class="form-control" name="start_date"
                               value="{{ request('start_date') }}">
                    </div>

                    <div class="col-md-3">
                        <label class="form-label">Tanggal Akhir</label>
                        <input type="date" class="form-control" name="end_date"
                               value="{{ request('end_date') }}">
                    </div>

                    <div class="col-md-2 d-flex align-items-end">
                        <button class="btn btn-primary w-100">
                            <i class="bi bi-search me-2"></i>Filter
                        </button>
                    </div>

                </div>

                <div class="mt-3">
                    <a href="{{ route('admin.reports.trips') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-x-circle me-2"></i>Reset Filter
                    </a>
                </div>

            </form>

        </div>
    </div>

    {{-- EXPORT --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body d-flex gap-2">
            <a href="{{ route('admin.reports.trips.export-excel', request()->all()) }}" class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-2"></i>Export Excel
            </a>

            <a href="{{ route('admin.reports.trips.export-pdf', request()->all()) }}" class="btn btn-danger">
                <i class="bi bi-file-earmark-pdf me-2"></i>Export PDF
            </a>
        </div>
    </div>

    {{-- DATA TABLE --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @if($trips->count() > 0)

                {{-- DESKTOP TABLE --}}
                <div class="table-responsive d-none d-md-block">
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
                                    <div class="fw-semibold">{{ $trip->vehicle->name }}</div>
                                    <small class="text-muted">{{ $trip->vehicle->plate_number }}</small>
                                </td>
                                <td>{{ $trip->tujuan }}</td>
                                <td>{{ $trip->km_awal ? number_format($trip->km_awal).' km' : '-' }}</td>
                                <td>{{ $trip->km_akhir ? number_format($trip->km_akhir).' km' : '-' }}</td>
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
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($trip->status === 'approved')
                                        <span class="badge bg-info">Disetujui</span>
                                    @elseif($trip->status === 'ongoing')
                                        <span class="badge bg-primary">Berjalan</span>
                                    @elseif($trip->status === 'completed')
                                        <span class="badge bg-success">Selesai</span>
                                    @elseif($trip->status === 'rejected')
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('admin.trips.show', $trip) }}"
                                       class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye me-1"></i>Lihat
                                    </a>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>


                {{-- MOBILE CARD LIST --}}
                <div class="d-md-none">

                    @foreach($trips as $trip)

                        <div class="p-3 mb-3 shadow-sm" style="background:white; border-radius:14px;">

                            {{-- ID + STATUS --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-secondary">#{{ $trip->id }}</span>

                                @if($trip->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($trip->status === 'approved')
                                    <span class="badge bg-info">Disetujui</span>
                                @elseif($trip->status === 'ongoing')
                                    <span class="badge bg-primary">Berjalan</span>
                                @elseif($trip->status === 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($trip->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>

                            {{-- KENDARAAN --}}
                            <div class="fw-bold mb-1">
                                🚗 {{ $trip->vehicle->name }}
                            </div>
                            <div class="text-muted mb-2">
                                {{ $trip->vehicle->plate_number }}
                            </div>

                            {{-- DETAIL INFO --}}
                            <div><strong>Driver:</strong> {{ $trip->driver->name }}</div>
                            <div><strong>Tujuan:</strong> {{ $trip->tujuan }}</div>
                            <div><strong>KM Awal:</strong> {{ $trip->km_awal ? number_format($trip->km_awal).' km' : '-' }}</div>
                            <div><strong>KM Akhir:</strong> {{ $trip->km_akhir ? number_format($trip->km_akhir).' km' : '-' }}</div>
                            <div><strong>Total KM:</strong>
                                @if($trip->total_km)
                                    <span class="text-success fw-bold">{{ number_format($trip->total_km) }} km</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div><strong>Tanggal:</strong> {{ $trip->created_at->format('d M Y') }}</div>

                            {{-- BUTTON --}}
                            <a href="{{ route('admin.trips.show', $trip) }}"
                               class="btn w-100 mt-3"
                               style="background:#f97316; color:white; border-radius:10px;">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>

                        </div>

                    @endforeach

                </div>


                {{-- PAGINATION --}}
                <div class="mt-3">
                    {{ $trips->appends(request()->query())->links() }}
                </div>

            @else

                {{-- EMPTY --}}
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">
                        @if(request()->hasAny(['vehicle_id','start_date','end_date']))
                            Tidak ada data perjalanan sesuai filter.
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