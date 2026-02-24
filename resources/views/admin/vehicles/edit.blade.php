@extends('layouts.app')

@section('title', 'Edit Kendaraan - Admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.vehicles.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Kendaraan</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.vehicles.update', $vehicle) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Kendaraan <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $vehicle->name) }}" 
                               placeholder="contoh: Toyota Avanza" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="plate_number" class="form-label">Nomor Plat <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('plate_number') is-invalid @enderror" 
                               id="plate_number" name="plate_number" value="{{ old('plate_number', $vehicle->plate_number) }}" 
                               placeholder="contoh: B 1234 XYZ" required>
                        @error('plate_number')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status <span class="text-danger">*</span></label>
                        <select class="form-select @error('status') is-invalid @enderror" 
                                id="status" name="status" required>
                            <option value="">Pilih Status</option>
                            <option value="available" {{ old('status', $vehicle->status) === 'available' ? 'selected' : '' }}>Tersedia</option>
                            <option value="in_use" {{ old('status', $vehicle->status) === 'in_use' ? 'selected' : '' }}>Digunakan</option>
                            <option value="maintenance" {{ old('status', $vehicle->status) === 'maintenance' ? 'selected' : '' }}>Maintenance</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Perbarui Kendaraan
                        </button>
                        <a href="{{ route('admin.vehicles.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
