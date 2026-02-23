@extends('layouts.app')

@section('title', 'Finish Trip - Driver')

@section('content')
<div class="mb-4">
    <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-stop-circle"></i> Finish Trip #{{ $trip->id }}</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Please complete the following information to finish your trip.
                </div>

                <form action="{{ route('driver.trips.finish.submit', $trip) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="km_akhir" class="form-label">Ending Odometer (KM) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('km_akhir') is-invalid @enderror" 
                               id="km_akhir" name="km_akhir" value="{{ old('km_akhir') }}" 
                               placeholder="e.g., 12445" min="{{ $trip->km_awal }}" required>
                        <small class="text-muted">Starting KM: {{ $trip->km_awal }}</small>
                        @error('km_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jam_in" class="form-label">Return Time <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('jam_in') is-invalid @enderror" 
                               id="jam_in" name="jam_in" value="{{ old('jam_in') }}" required>
                        <small class="text-muted">Departure: {{ $trip->jam_out->format('d M Y H:i') }}</small>
                        @error('jam_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto_akhir" class="form-label">Ending Photo <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror" 
                               id="foto_akhir" name="foto_akhir" accept="image/*" required>
                        @error('foto_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="preview_foto_akhir" src="" alt="Preview" class="img-thumbnail" style="max-width: 300px; display: none;">
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Finish Trip
                        </button>
                        <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-secondary">
                            Cancel
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
    document.getElementById('foto_akhir').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('preview_foto_akhir');
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });
</script>
@endpush
