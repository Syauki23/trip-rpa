@extends('layouts.app')

@section('title', 'Perjalanan Saya - Driver')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-list-ul"></i> Perjalanan Saya</h2>
    <a href="{{ route('driver.trips.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Buat Perjalanan
    </a>
</div>

<div class="card">
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
                                <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-sm btn-outline-primary">
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
                <p class="text-muted mt-3">Tidak ada perjalanan. Buat perjalanan pertama Anda!</p>
                <a href="{{ route('driver.trips.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Buat Perjalanan
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
