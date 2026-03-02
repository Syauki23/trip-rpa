@extends('layouts.app')

@section('title', 'Riwayat Perjalanan - Driver')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-clock-history me-2"></i>Riwayat Perjalanan</h2>
        <a href="{{ route('driver.trips.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Perjalanan Saya
        </a>
    </div>

    {{-- ALERT --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="bi bi-exclamation-triangle me-2"></i>{{ session('error') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            @if($trips->count() > 0)

                {{-- DESKTOP TABLE --}}
                <div class="table-responsive d-none d-md-block">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Tanggal</th>
                                <th>Driver</th>
                                <th>Kendaraan</th>
                                <th>KM Awal</th>
                                <th>Waktu Berangkat</th>
                                <th>Tujuan</th>
                                <th>KM Akhir</th>
                                <th>Waktu Kembali</th>
                                <th>Status</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($trips as $trip)
                                <tr>
                                    <td><span class="badge bg-secondary">#{{ $trip->id }}</span></td>
                                    <td>
                                        @if($trip->jam_out)
                                            {{ $trip->jam_out->format('d M Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $trip->driver->name ?? '-' }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $trip->vehicle->name }}</div>
                                        <small class="text-muted">{{ $trip->vehicle->plate_number }}</small>
                                    </td>
                                    <td>{{ number_format($trip->km_awal) }} km</td>
                                    <td>
                                        @if($trip->jam_out)
                                            {{ $trip->jam_out->format('H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>{{ $trip->tujuan }}</td>
                                    <td>
                                        @if($trip->km_akhir)
                                            {{ number_format($trip->km_akhir) }} km
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->jam_in)
                                            {{ $trip->jam_in->format('H:i') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($trip->status === 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($trip->status === 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('driver.trips.show', $trip) }}" 
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

                        <div class="p-3 mb-3 shadow-sm" 
                             style="background:white; border-radius:14px;">

                            {{-- ID + STATUS --}}
                            <div class="d-flex justify-content-between mb-2">
                                <span class="badge bg-secondary">#{{ $trip->id }}</span>

                                @if($trip->status === 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($trip->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @endif
                            </div>

                            {{-- Kendaraan --}}
                            <div class="fw-bold">
                                🚗 {{ $trip->vehicle->name }}
                            </div>
                            <div class="text-muted mb-2">{{ $trip->vehicle->plate_number }}</div>

                            {{-- Detail --}}
                            <div><strong>Driver:</strong> {{ $trip->driver->name ?? '-' }}</div>
                            <div><strong>Tujuan:</strong> {{ $trip->tujuan }}</div>
                            <div>
                                <strong>Tanggal:</strong> 
                                @if($trip->jam_out)
                                    {{ $trip->jam_out->format('d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div>
                                <strong>Waktu Berangkat:</strong> 
                                @if($trip->jam_out)
                                    {{ $trip->jam_out->format('H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div><strong>KM Awal:</strong> {{ number_format($trip->km_awal) }} km</div>
                            <div>
                                <strong>KM Akhir:</strong> 
                                @if($trip->km_akhir)
                                    {{ number_format($trip->km_akhir) }} km
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div>
                                <strong>Waktu Kembali:</strong> 
                                @if($trip->jam_in)
                                    {{ $trip->jam_in->format('H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>

                            {{-- Button --}}
                            <a href="{{ route('driver.trips.show', $trip) }}"
                               class="btn w-100 mt-3"
                               style="background:#f97316;color:white;border-radius:10px;">
                                <i class="bi bi-eye me-1"></i>Lihat Detail
                            </a>

                        </div>

                    @endforeach

                </div>

                {{-- PAGINATION --}}
                <div class="mt-3">
                    {{ $trips->links() }}
                </div>

            @else

                {{-- EMPTY STATE --}}
                <div class="text-center py-5">
                    <i class="bi bi-inbox fs-1 text-muted"></i>
                    <p class="text-muted mt-3">
                        Belum ada riwayat perjalanan yang selesai atau ditolak.
                    </p>

                    <a href="{{ route('driver.trips.index') }}" class="btn btn-primary">
                        <i class="bi bi-list-ul me-2"></i>Lihat Semua Perjalanan
                    </a>
                </div>

            @endif

        </div>
    </div>

</div>
@endsection