@extends('layouts.app')

@section('title', 'Trips - Supervisor')

@section('content')
<div class="mb-4">
    <h2><i class="bi bi-list-ul"></i> Trip Management</h2>
</div>

<div class="card">
    <div class="card-body">
        @if($trips->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Driver</th>
                            <th>Vehicle</th>
                            <th>Destination</th>
                            <th>Date Out</th>
                            <th>Status</th>
                            <th>Actions</th>
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
                                <a href="{{ route('supervisor.trips.show', $trip) }}" class="btn btn-sm btn-outline-primary">
                                    <i class="bi bi-eye"></i> View
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
                <p class="text-muted mt-3">No trips found.</p>
            </div>
        @endif
    </div>
</div>
@endsection
