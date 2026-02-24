@extends('layouts.app')

@section('title', 'Pengajuan Masuk - Supervisor')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-inbox me-2"></i>Pengajuan Masuk</h2>
        <a href="{{ route('supervisor.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
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
                                <th>Driver</th>
                                <th>Kendaraan</th>
                                <th>Tujuan</th>
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
                                    <td>{{ $trip->created_at->format('d M Y H:i') }}</td>
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

                <div class="mt-3">
                    {{ $trips->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">Tidak ada pengajuan pending saat ini.</p>
                    <a href="{{ route('supervisor.trips.all') }}" class="btn btn-primary">
                        <i class="bi bi-list-ul me-2"></i>Lihat Semua Perjalanan
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
