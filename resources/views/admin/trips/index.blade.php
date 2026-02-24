@extends('layouts.app')

@section('title', 'Semua Perjalanan - Admin')

@section('content')
<!-- Mobile Section Title -->
<div class="mobile-only mobile-section-title">
    <i class="bi bi-list-ul me-2"></i>Semua Perjalanan
</div>

<!-- Desktop Header -->
<div class="mb-4 desktop-only">
    <h2><i class="bi bi-list-ul"></i> Semua Perjalanan</h2>
</div>

<!-- Desktop Card -->
<div class="card desktop-only">
    <div class="card-body">
        @if($trips->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver</th>
                            <th>Kendaraan</th>
                            <th>Tujuan</th>
                            <th>Tanggal Keluar</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($trips as $trip)
                        <tr>
                            <td>{{ $trip->id }}</td>
                            <td>{{ $trip->driver->name }}</td>
                            <td>
                                {{ $trip->vehicle->name }}<br>
                                <small class="text-muted">{{ $trip->vehicle->plate_number }}</small>
                            </td>
                            <td>{{ $trip->tujuan }}</td>
                            <td>{{ $trip->jam_out->format('d M Y H:i') }}</td>
                            <td>{!! $trip->status_badge !!}</td>
                            <td>
                                <a href="{{ route('admin.trips.show', $trip) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> Lihat
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
                <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Tidak ada perjalanan ditemukan.</p>
            </div>
        @endif
    </div>
</div>

<!-- Mobile List View -->
<div class="mobile-only mobile-list-view">
    @if($trips->count() > 0)
        @foreach($trips as $trip)
        <div class="mobile-list-item" onclick="window.location='{{ route('admin.trips.show', $trip) }}'">
            <div class="item-header">
                <div>
                    <div class="item-title">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                        {{ $trip->tujuan }}
                    </div>
                    <div class="item-subtitle">
                        Driver: {{ $trip->driver->name ?? '-' }}
                    </div>
                </div>
                <div>
                    {!! $trip->status_badge !!}
                </div>
            </div>
            
            <div class="item-meta">
                <div class="meta-item">
                    <i class="bi bi-car-front"></i>
                    <span>{{ $trip->vehicle->name ?? '-' }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ $trip->jam_out->format('d M Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-hash"></i>
                    <span>ID: {{ $trip->id }}</span>
                </div>
            </div>
            
            <div class="item-actions">
                <a href="{{ route('admin.trips.show', $trip) }}" class="btn btn-primary btn-sm flex-fill" onclick="event.stopPropagation()">
                    <i class="bi bi-eye"></i> Lihat Detail
                </a>
            </div>
        </div>
        @endforeach
        
        <div class="mt-3">
            {{ $trips->links() }}
        </div>
    @else
        <div class="mobile-empty-state">
            <i class="bi bi-inbox"></i>
            <h5>Tidak Ada Perjalanan</h5>
            <p>Belum ada data perjalanan</p>
        </div>
    @endif
</div>
@endsection
