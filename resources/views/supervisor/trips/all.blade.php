@extends('layouts.app')

@section('title', 'Semua Perjalanan - Supervisor')

@section('content')
<div class="container-fluid py-4">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-list-ul me-2"></i>Semua Perjalanan</h2>
        <div>
            <a href="{{ route('supervisor.trips.create') }}" class="btn btn-primary me-2">
                <i class="bi bi-plus-circle me-2"></i>Buat Perjalanan
            </a>
            <a href="{{ route('supervisor.dashboard') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
            </a>
        </div>
    </div>

    {{-- ALERT --}}
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

                {{-- DESKTOP TABLE (MD UP) --}}
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
                                    <td>{{ $trip->jam_out->format('d M Y') }}</td>
                                    <td>{{ $trip->driver_name ?? '-' }}</td>
                                    <td>
                                        <div class="fw-semibold">{{ $trip->vehicle->name ?? '-' }}</div>
                                        <small class="text-muted">{{ $trip->vehicle->plate_number ?? '-' }}</small>
                                    </td>
                                    <td>{{ number_format($trip->km_awal) }} km</td>
                                    <td>{{ $trip->jam_out->format('H:i') }}</td>
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
                                        @if($trip->status === 'pending')
                                            <span class="badge bg-warning text-dark">Menunggu</span>
                                        @elseif($trip->status === 'approved')
                                            <span class="badge bg-info">Disetujui</span>
                                        @elseif($trip->status === 'ongoing')
                                            <span class="badge bg-primary">Sedang Berjalan</span>
                                        @elseif($trip->status === 'completed')
                                            <span class="badge bg-success">Selesai</span>
                                        @elseif($trip->status === 'rejected')
                                            <span class="badge bg-danger">Ditolak</span>
                                        @elseif($trip->status === 'verified')
                                            <span class="badge bg-dark">Terverifikasi</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('supervisor.trips.show', $trip) }}" 
                                           class="btn btn-sm btn-outline-primary me-1">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                        <a href="{{ route('supervisor.trips.edit', $trip) }}" 
                                           class="btn btn-sm btn-outline-warning me-1">
                                            <i class="bi bi-pencil"></i> Edit
                                        </a>
                                        <form action="{{ route('supervisor.trips.destroy', $trip) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus perjalanan ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger">
                                                <i class="bi bi-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                {{-- MOBILE CARD LIST (SM ONLY) --}}
                <div class="d-md-none">

                    @foreach($trips as $trip)
                        <div class="p-3 mb-3 shadow-sm"
                             style="background:white; border-radius:14px;">

                            {{-- Row 1: ID + Status --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span class="badge bg-secondary">#{{ $trip->id }}</span>

                                @if($trip->status === 'pending')
                                    <span class="badge bg-warning text-dark">Menunggu</span>
                                @elseif($trip->status === 'approved')
                                    <span class="badge bg-info">Disetujui</span>
                                @elseif($trip->status === 'ongoing')
                                    <span class="badge bg-primary">Sedang Berjalan</span>
                                @elseif($trip->status === 'completed')
                                    <span class="badge bg-success">Selesai</span>
                                @elseif($trip->status === 'rejected')
                                    <span class="badge bg-danger">Ditolak</span>
                                @elseif($trip->status === 'verified')
                                    <span class="badge bg-dark">Terverifikasi</span>
                                @endif
                            </div>

                            {{-- Kendaraan --}}
                            <div class="fw-bold mb-1">
                                🚗 {{ $trip->vehicle->name }}
                            </div>
                            <div class="text-muted mb-2">
                                {{ $trip->vehicle->plate_number }}
                            </div>

                            {{-- Info --}}
                            <div><strong>Driver:</strong> {{ $trip->driver_name ?? '-' }}</div>
                            <div><strong>Tujuan:</strong> {{ $trip->tujuan }}</div>
                            <div><strong>Tanggal:</strong> {{ $trip->jam_out->format('d M Y') }}</div>
                            <div><strong>Waktu Berangkat:</strong> {{ $trip->jam_out->format('H:i') }}</div>
                            <div><strong>KM Awal:</strong> {{ number_format($trip->km_awal) }} km</div>
                            <div><strong>KM Akhir:</strong> 
                                @if($trip->km_akhir)
                                    {{ number_format($trip->km_akhir) }} km
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>
                            <div><strong>Waktu Kembali:</strong> 
                                @if($trip->jam_in)
                                    {{ $trip->jam_in->format('H:i') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </div>

                            {{-- Button --}}
                            <div class="d-flex gap-2 mt-3">
                                <a href="{{ route('supervisor.trips.show', $trip) }}"
                                   class="btn btn-primary flex-fill">
                                    <i class="bi bi-eye"></i> Lihat
                                </a>
                                <a href="{{ route('supervisor.trips.edit', $trip) }}"
                                   class="btn btn-warning flex-fill">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('supervisor.trips.destroy', $trip) }}" 
                                      method="POST" 
                                      class="flex-fill"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus perjalanan ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger w-100">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </div>

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
                    <p class="text-muted mt-3">Belum ada data perjalanan.</p>
                </div>

            @endif
        </div>
    </div>
</div>
@endsection