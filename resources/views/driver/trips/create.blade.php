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
                        <label for="petugas_1" class="form-label">Petugas 1 <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('petugas_1') is-invalid @enderror" 
                               id="petugas_1" name="petugas_1" value="{{ old('petugas_1') }}" 
                               placeholder="Nama petugas yang jaga" required>
                        @error('petugas_1')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="km_awal_display" class="form-label">Odometer Awal (KM) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('km_awal') is-invalid @enderror" 
                               id="km_awal_display" 
                               placeholder="contoh: 1.500" inputmode="numeric" autocomplete="off" required>
                        <input type="hidden" id="km_awal" name="km_awal" value="{{ old('km_awal') }}">
                        <small class="text-muted">Masukkan angka odometer. Akan diformat otomatis.</small>
                        @error('km_awal')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Waktu Berangkat <span class="text-danger">*</span></label>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="tanggal_berangkat" class="form-label small">Tanggal</label>
                                <input type="date" class="form-control @error('tanggal_berangkat') is-invalid @enderror" 
                                       id="tanggal_berangkat" name="tanggal_berangkat" value="{{ old('tanggal_berangkat') }}" required>
                                @error('tanggal_berangkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6">
                                <label for="jam_berangkat" class="form-label small">Jam</label>
                                <input type="time" class="form-control @error('jam_berangkat') is-invalid @enderror" 
                                       id="jam_berangkat" name="jam_berangkat" value="{{ old('jam_berangkat') }}" required>
                                @error('jam_berangkat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="foto_awal" class="form-label">Foto Awal <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('foto_awal') is-invalid @enderror" 
                               id="foto_awal" name="foto_awal" accept="image/*" capture="environment" required>
                        <small class="text-muted d-block mt-1">
                            Foto dashboard mobil yang terlihat KM (akan dikompresi otomatis sebelum diupload).
                        </small>
                        @error('foto_awal')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="preview_foto_awal" src="" alt="Pratinjau" class="img-thumbnail" style="max-width: 300px; display: none;">
                        </div>
                        <div id="compression_status" class="mt-2" style="display: none;">
                            <small class="text-info">
                                <i class="bi bi-hourglass-split"></i> Mengkompresi gambar...
                            </small>
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
    // Setup auto-format ribuan dengan hidden input
    (function() {
        const displayInput = document.getElementById('km_awal_display');
        const hiddenInput = document.getElementById('km_awal');
        
        if (displayInput && hiddenInput) {
            // Set initial value if exists
            if (hiddenInput.value) {
                displayInput.value = new Intl.NumberFormat('id-ID').format(hiddenInput.value);
            }
            
            // Format saat user mengetik
            displayInput.addEventListener('input', function() {
                let value = this.value.replace(/\D/g, ''); // hanya angka
                
                // Update hidden input dengan angka murni
                hiddenInput.value = value;
                
                // Format display dengan ribuan
                if (value) {
                    this.value = new Intl.NumberFormat('id-ID').format(value);
                } else {
                    this.value = '';
                }
            });
        }
    })();
    
    // Handle image compression and preview
    document.getElementById('foto_awal').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleImageCompression(file, e.target);
        }
    });

    function handleImageCompression(file, inputElement) {
        // Show compression status
        const statusDiv = document.getElementById('compression_status');
        const preview = document.getElementById('preview_foto_awal');
        
        statusDiv.style.display = 'block';
        preview.style.display = 'none';

        // Check if file is an image
        if (!file.type.match('image.*')) {
            alert('File harus berupa gambar!');
            statusDiv.style.display = 'none';
            return;
        }

        const reader = new FileReader();
        
        reader.onload = function(event) {
            const img = new Image();
            
            img.onload = function() {
                // Create canvas for compression
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');
                
                // Calculate new dimensions (max width 1200px)
                let width = img.width;
                let height = img.height;
                const maxWidth = 1200;
                
                if (width > maxWidth) {
                    height = (height * maxWidth) / width;
                    width = maxWidth;
                }
                
                // Set canvas dimensions
                canvas.width = width;
                canvas.height = height;
                
                // Draw image on canvas
                ctx.drawImage(img, 0, 0, width, height);
                
                // Convert canvas to blob with compression (quality 0.7 = 70%)
                canvas.toBlob(function(blob) {
                    // Create new File object from blob
                    const compressedFile = new File([blob], file.name, {
                        type: 'image/jpeg',
                        lastModified: Date.now()
                    });
                    
                    // Create new FileList and replace input files
                    const dataTransfer = new DataTransfer();
                    dataTransfer.items.add(compressedFile);
                    inputElement.files = dataTransfer.files;
                    
                    // Show preview
                    const previewUrl = URL.createObjectURL(blob);
                    preview.src = previewUrl;
                    preview.style.display = 'block';
                    
                    // Hide compression status
                    statusDiv.style.display = 'none';
                    
                    // Show success message with file size
                    const fileSizeKB = (blob.size / 1024).toFixed(2);
                    const originalSizeKB = (file.size / 1024).toFixed(2);
                    
                    console.log('Original size: ' + originalSizeKB + ' KB');
                    console.log('Compressed size: ' + fileSizeKB + ' KB');
                    console.log('Compression ratio: ' + ((1 - blob.size / file.size) * 100).toFixed(2) + '%');
                    
                    // Show success notification
                    if (fileSizeKB < 2048) {
                        statusDiv.innerHTML = '<small class="text-success"><i class="bi bi-check-circle"></i> Gambar berhasil dikompresi (' + fileSizeKB + ' KB)</small>';
                        statusDiv.style.display = 'block';
                        setTimeout(() => {
                            statusDiv.style.display = 'none';
                        }, 3000);
                    } else {
                        statusDiv.innerHTML = '<small class="text-warning"><i class="bi bi-exclamation-triangle"></i> Ukuran masih besar (' + fileSizeKB + ' KB), coba foto dengan resolusi lebih rendah</small>';
                        statusDiv.style.display = 'block';
                    }
                    
                }, 'image/jpeg', 0.7); // Quality 70%
            };
            
            img.onerror = function() {
                alert('Gagal memuat gambar!');
                statusDiv.style.display = 'none';
            };
            
            img.src = event.target.result;
        };
        
        reader.onerror = function() {
            alert('Gagal membaca file!');
            statusDiv.style.display = 'none';
        };
        
        reader.readAsDataURL(file);
    }
</script>
@endpush
