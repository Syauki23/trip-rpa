@extends('layouts.app')

@section('title', 'Edit Perjalanan')

@section('content')
<div class="mb-4">
    <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0"><i class="bi bi-pencil"></i> Edit Perjalanan</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('driver.trips.update', $trip) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="driver_name" class="form-label">Nama Sopir <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('driver_name') is-invalid @enderror" 
                       id="driver_name" name="driver_name" value="{{ old('driver_name', $trip->driver_name) }}" 
                       placeholder="Nama sopir yang mengendarai" required>
                @error('driver_name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                <select class="form-select @error('vehicle_id') is-invalid @enderror" 
                        id="vehicle_id" 
                        name="vehicle_id" 
                        required>
                    <option value="">Pilih Kendaraan</option>
                    @foreach($vehicles as $vehicle)
                        <option value="{{ $vehicle->id }}" {{ old('vehicle_id', $trip->vehicle_id) == $vehicle->id ? 'selected' : '' }}>
                            {{ $vehicle->name }} - {{ $vehicle->plate_number }}
                        </option>
                    @endforeach
                </select>
                @error('vehicle_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="tujuan" class="form-label">Tujuan <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('tujuan') is-invalid @enderror" 
                       id="tujuan" 
                       name="tujuan" 
                       value="{{ old('tujuan', $trip->tujuan) }}"
                       placeholder="Contoh: Kantor Cabang Jakarta"
                       required>
                @error('tujuan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                          id="keperluan" 
                          name="keperluan" 
                          rows="3" 
                          placeholder="Jelaskan keperluan perjalanan"
                          required>{{ old('keperluan', $trip->keperluan) }}</textarea>
                @error('keperluan')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="petugas_1" class="form-label">Petugas  <span class="text-danger">*</span></label>
                <input type="text" 
                       class="form-control @error('petugas_1') is-invalid @enderror" 
                       id="petugas_1" 
                       name="petugas_1" 
                       value="{{ old('petugas_1', $trip->petugas_1) }}"
                       placeholder="Nama petugas yang jaga"
                       required>
                @error('petugas_1')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="km_awal" class="form-label">KM Awal <span class="text-danger">*</span></label>
                <input type="number" 
                       class="form-control @error('km_awal') is-invalid @enderror" 
                       id="km_awal" 
                       name="km_awal" 
                       value="{{ old('km_awal', $trip->km_awal) }}"
                       min="0"
                       placeholder="Contoh: 12500"
                       required>
                @error('km_awal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">Waktu Berangkat <span class="text-danger">*</span></label>
                <div class="row">
                    <div class="col-md-6">
                        <label for="tanggal_berangkat" class="form-label small">Tanggal</label>
                        <input type="date" 
                               class="form-control @error('tanggal_berangkat') is-invalid @enderror" 
                               id="tanggal_berangkat" 
                               name="tanggal_berangkat" 
                               value="{{ old('tanggal_berangkat', $trip->jam_out->format('Y-m-d')) }}"
                               required>
                        @error('tanggal_berangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6">
                        <label for="jam_berangkat" class="form-label small">Jam</label>
                        <input type="time" 
                               class="form-control @error('jam_berangkat') is-invalid @enderror" 
                               id="jam_berangkat" 
                               name="jam_berangkat" 
                               value="{{ old('jam_berangkat', $trip->jam_out->format('H:i')) }}"
                               required>
                        @error('jam_berangkat')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="foto_awal" class="form-label">Foto Odometer Awal</label>
                <input type="file" 
                       class="form-control @error('foto_awal') is-invalid @enderror" 
                       id="foto_awal" 
                       name="foto_awal"
                       accept="image/jpeg,image/png,image/jpg">
                <small class="text-muted">Kosongkan jika tidak ingin mengubah foto. Max: 2MB</small>
                @error('foto_awal')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                
                @if($trip->foto_awal)
                    <div class="mt-2">
                        <label class="form-label">Foto Saat Ini:</label>
                        <div>
                            <img src="{{ asset('storage/' . $trip->foto_awal) }}" 
                                 alt="Foto Awal" 
                                 class="img-thumbnail"
                                 style="max-width: 300px;">
                        </div>
                    </div>
                @endif
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-save"></i> Simpan Perubahan
                </button>
                <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-secondary">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
