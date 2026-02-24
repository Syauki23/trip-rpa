@extends('layouts.app')

@section('title', 'Perjalanan Saya - Driver')

@section('content')
<!-- Mobile Header Title -->
<div class="mobile-only mobile-section-title">
    <i class="bi bi-list-ul me-2"></i>Perjalanan Saya
</div>

<!-- Desktop Header -->
<div class="d-flex justify-content-between align-items-center mb-4 desktop-only">
    <h2><i class="bi bi-list-ul"></i> Perjalanan Saya</h2>
    <a href="{{ route('driver.trips.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Buat Perjalanan
    </a>
</div>

<div class="card desktop-only">
    <div class="card-body">
        @if($trips->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
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
                            <td>
                                {{ $trip->vehicle->name }}<br>
                                <small class="text-muted">{{ $trip->vehicle->plate_number }}</small>
                            </td>
                            <td>{{ $trip->tujuan }}</td>
                            <td>{{ $trip->jam_out->format('d M Y H:i') }}</td>
                            <td>{!! $trip->status_badge !!}</td>
                            <td>
                                @if($trip->status === 'approved')
                                    <a href="{{ route('driver.trips.finish', $trip) }}" class="btn btn-sm btn-outline-success">
                                        <i class="bi bi-check-circle"></i> Selesaikan
                                    </a>
                                @else
                                    <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-eye"></i> Lihat
                                    </a>
                                @endif
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
                <p class="text-muted mt-3">Tidak ada perjalanan. Buat perjalanan pertama Anda!</p>
                <a href="{{ route('driver.trips.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Perjalanan
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Mobile List View -->
<div class="mobile-only mobile-list-view">
    @if($trips->count() > 0)
        @foreach($trips as $trip)
        <div class="mobile-list-item" onclick="window.location='{{ $trip->status === 'approved' ? route('driver.trips.finish', $trip) : route('driver.trips.show', $trip) }}'">
            <div class="item-header">
                <div>
                    <div class="item-title">
                        <i class="bi bi-geo-alt-fill text-danger me-1"></i>
                        {{ $trip->tujuan }}
                    </div>
                    <div class="item-subtitle">
                        {{ $trip->vehicle->name }} - {{ $trip->vehicle->plate_number }}
                    </div>
                </div>
                <div>
                    {!! $trip->status_badge !!}
                </div>
            </div>
            
            <div class="item-meta">
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ $trip->jam_out->format('d M Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-clock"></i>
                    <span>{{ $trip->jam_out->format('H:i') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-hash"></i>
                    <span>ID: {{ $trip->id }}</span>
                </div>
            </div>
            
            <div class="item-actions">
                @if($trip->status === 'approved')
                    <a href="{{ route('driver.trips.finish', $trip) }}" class="btn btn-success btn-sm flex-fill" onclick="event.stopPropagation()">
                        <i class="bi bi-check-circle"></i> Selesaikan
                    </a>
                @else
                    <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-primary btn-sm flex-fill" onclick="event.stopPropagation()">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                @endif
            </div>
        </div>
        @endforeach
        
        <div class="mt-3">
            {{ $trips->links() }}
        </div>
    @else
        <div class="mobile-empty-state">
            <i class="bi bi-inbox"></i>
            <h5>Belum Ada Perjalanan</h5>
            <p>Buat perjalanan pertama Anda dengan menekan tombol di bawah</p>
            <a href="{{ route('driver.trips.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Buat Perjalanan
            </a>
        </div>
    @endif
</div>

<!-- Floating Action Button (Mobile) -->
<a href="{{ route('driver.trips.create') }}" class="fab mobile-only">
    <i class="bi bi-plus-lg"></i>
</a>
@endsection
