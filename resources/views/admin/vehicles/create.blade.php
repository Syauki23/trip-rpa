@extends('layouts.app')

@section('title', 'Add Vehicle - Admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Add New Vehicle</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicles.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Vehicle Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name') }}" 
                               placeholder="e.g., Toyota Avanza" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="plate_number" class="form-label">Plate Number <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('plate_number') is-invalid @enderror" 
                               id="plate_number" name="plate_number" value="{{ old('plate_number') }}" 
                               placeholder="e.g., B 1234 XYZ" required>
                        @error('plate_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="">Select Status</option>
                            <option value="available" {{ old('status') === 'available' ? 'selected' : '' }}>Available</option>
                            <option value="in_use" {{ old('status') === 'in_use' ? 'selected' : '' }}>In Use</option>
                            <option value="maintenance" {{ old('status') === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Save Vehicle
                        </button>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
