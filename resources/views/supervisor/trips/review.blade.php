@extends('layouts.app')

@section('title', 'Selesai & Review - Supervisor')

@section('content')
<div class="container-fluid py-4">

    {{-- === HEADER === --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="mb-0"><i class="bi bi-check-circle me-2"></i>Selesai & Review</h2>
        <a href="{{ route('supervisor.dashboard') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-2"></i>Kembali ke Dashboard
        </a>
    </div>

    {{-- === FILTER FORM === --}}
    <form method="GET" class="mb-4">
        <div class="row g-3">

            <div class="col-md-3">
                <label class="form-label">Tanggal Dari</label>
                <input type="date" name="date_from" class="form-control"
                       value="{{ request('date_from') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Tanggal Sampai</label>
                <input type="date" name="date_to" class="form-control"
                       value="{{ request('date_to') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Driver</label>
                <input type="text" name="driver" class="form-control"
                       placeholder="Nama driver"
                       value="{{ request('driver') }}">
            </div>

            <div class="col-md-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>
                        Selesai
                    </option>
                    <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>
                        Pending
                    </option>
                    <option value="ongoing" {{ request('status')=='ongoing' ? 'selected' : '' }}>
                        Sedang Jalan
                    </option>
                </select>
            </div>

        </div>

        <div class="mt-3 d-flex gap-2">
            <button class="btn btn-primary">Filter</button>

            <a href="{{ route('supervisor.trips.review') }}" class="btn btn-secondary">
                Reset
            </a>

            <a href="{{ route('supervisor.trips.review.export', request()->all()) }}"
               class="btn btn-success">
                <i class="bi bi-file-earmark-excel me-1"></i>
                Export Excel
            </a>
        </div>
    </form>

    {{-- === DESKTOP TABLE (desktop-only) === --}}
    <div class="desktop-only">
        <div class="card border-0 shadow-sm">
            <div class="card-body">
                @if($trips->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Driver</th>
                                    <th>Tujuan</th>
                                    <th>Kendaraan</th>
                                    <th>Plat</th>
                                    <th>Jarak Tempuh</th>
                                    <th>Tanggal</th>
                                    <th>Status</th>
                                    <th class="text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trips as $trip)
                                    <tr>
                                        <td>{{ $trip->driver->name ?? '-' }}</td>
                                        <td>{{ $trip->tujuan }}</td>
                                        <td>{{ $trip->vehicle->name ?? '-' }}</td>
                                        <td>{{ $trip->vehicle->plate_number ?? '-' }}</td>
                                        <td>
                                            @if($trip->total_km)
                                                <strong class="text-success">{{ number_format($trip->total_km) }} km</strong>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>{{ $trip->updated_at->format('d M Y') }}</td>
                                        <td><span class="badge bg-success">Selesai</span></td>
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

                    <div class="mt-3">
                        {{ $trips->links() }}
                    </div>

                @else
                    <div class="text-center py-5">
                        <i class="bi bi-inbox fs-1 text-muted"></i>
                        <p class="text-muted mt-3">Belum ada perjalanan yang selesai untuk direview.</p>
                        <a href="{{ route('supervisor.trips.all') }}" class="btn btn-primary">
                            <i class="bi bi-list-ul me-2"></i>Lihat Semua Perjalanan
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    {{-- === MOBILE CARD LIST (mobile-only) === --}}
    <div class="mobile-only">
        @foreach($trips as $trip)
        <div class="card shadow-sm mb-3 p-3">

            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="badge bg-secondary">#{{ $trip->id }}</span>
                <span class="badge bg-success">Selesai</span>
            </div>

            <div class="fw-bold">{{ $trip->vehicle->name ?? '-' }}</div>
            <div class="text-muted">{{ $trip->vehicle->plate_number ?? '-' }}</div>

            <div class="mt-2">
                <strong>Driver:</strong> {{ $trip->driver->name ?? '-' }}<br>
                <strong>Tujuan:</strong> {{ $trip->tujuan }}<br>
                <strong>Tanggal:</strong> {{ $trip->updated_at->format('d M Y') }}<br>
            </div>

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

        <div class="mt-3">
            {{ $trips->links() }}
        </div>
    </div>

</div>
@endsection