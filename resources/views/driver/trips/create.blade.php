@extends('layouts.app')

@section('title', 'Buat Perjalanan - Driver')

@section('content')
<div class="mb-4">
    <a href="{{ route('driver.trips.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Buat Perjalanan Baru</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('driver.trips.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="vehicle_id" class="form-label">Kendaraan <span class="text-danger">*</span></label>
                        <select class="form-select @error('vehicle_id') is-invalid @enderror" 
                                id="vehicle_id" name="vehicle_id" required>
                            <option value="">Pilih Kendaraan</option>
                            @foreach($vehicles as $vehicle)
                                <option value="{{ $vehicle->id }}" {{ old('vehicle_id') == $vehicle->id ? 'selected' : '' }}>
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
                        <input type="text" class="form-control @error('tujuan') is-invalid @enderror" 
                               id="tujuan" name="tujuan" value="{{ old('tujuan') }}" 
                               placeholder="contoh: Kantor Jakarta" required>
                        @error('tujuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="keperluan" class="form-label">Keperluan <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('keperluan') is-invalid @enderror" 
                                  id="keperluan" name="keperluan" rows="3" 
                                  placeholder="Jelaskan keperluan perjalanan ini" required>{{ old('keperluan') }}</textarea>
                        @error('keperluan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="km_awal" class="form-label">Odometer Awal (KM) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('km_awal') is-invalid @enderror" 
                               id="km_awal" name="km_awal" value="{{ old('km_awal') }}" 
                               placeholder="contoh: 12345" min="0" required>
                        @error('km_awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jam_out" class="form-label">Waktu Berangkat <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('jam_out') is-invalid @enderror" 
                               id="jam_out" name="jam_out" value="{{ old('jam_out') }}" required>
                        @error('jam_out')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto_awal" class="form-label">Foto Awal <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('foto_awal') is-invalid @enderror" 
                               id="foto_awal" name="foto_awal" accept="image/*" required>
                        @error('foto_awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="preview_foto_awal" src="" alt="Pratinjau" class="img-thumbnail" style="max-width: 300px; display: none;">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-save"></i> Buat Perjalanan
                        </button>
                        <a href="{{ route('driver.trips.index') }}" class="btn btn-secondary">
                            Batal
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.getElementById('foto_awal').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview_foto_awal');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
