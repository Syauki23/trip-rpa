@extends('layouts.app')

@section('title', 'Vehicles - Admin')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h2><i class="bi bi-car-front"></i> Vehicle Management</h2>
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Add Vehicle
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($vehicles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Plate Number</th>
                            <th>Status</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td><span class="badge bg-secondary">{{ $vehicle->plate_number }}</span></td>
                            <td>
                                @if($vehicle->status === 'available')
                                    <span class="badge bg-success">Available</span>
                                @elseif($vehicle->status === 'in_use')
                                    <span class="badge bg-warning">In Use</span>
                                @else
                                    <span class="badge bg-danger">Maintenance</span>
                                @endif
                            </td>
                            <td>{{ $vehicle->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" 
                                          onsubmit="return confirm('Are you sure you want to delete this vehicle?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $vehicles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-car-front text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">No vehicles found. Add your first vehicle!</p>
                <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Add Vehicle
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
