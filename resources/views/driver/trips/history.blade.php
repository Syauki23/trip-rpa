@extends('layouts.app')

@section('title', 'Riwayat Perjalanan - Driver')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Perjalanan</h2>
        <a href="{{ route('driver.trips.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Perjalanan Saya
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">
            @if($trips->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Kendaraan</th>
                                <th>Destination</th>
                                <th>Date Out</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($trips as $trip)
                                <tr>
                                    <td><span class="badge bg-secondary">#{{ $trip->id }}</span></td>
                                    <td>
                                        <div class="fw-semibold">{{ $trip->vehicle->name }}</div>
                                        <small class="text-muted">{{ $trip->vehicle->plate_number }}</small>
                                    </td>
                                    <td>{{ $trip->tujuan }}</td>
                                    <td>
                                        @if($trip->jam_out)
                                            {{ $trip->jam_out->format('d M Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->status === 'completed')
                                            <span class="badge bg-success">Completed</span>
                                        @elseif($trip->status === 'rejected')
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('driver.trips.show', $trip) }}" 
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
                    {{ $trips->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Belum ada riwayat perjalanan yang selesai atau ditolak.</p>
                    <a href="{{ route('driver.trips.index') }}" class="btn btn-primary">
                        <i class="bi bi-list-ul me-2"></i>Lihat Semua Perjalanan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
