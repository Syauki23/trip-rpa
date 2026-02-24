@extends('layouts.app')

@section('title', 'Selesaikan Perjalanan - Driver')

@section('content')
<div class="mb-4">
    <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-stop-circle"></i> Selesaikan Perjalanan #{{ $trip->id }}</h4>
            </div>
            <div class="card-body">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> Silakan lengkapi informasi berikut untuk menyelesaikan perjalanan Anda.
                </div>

                <form action="{{ route('driver.trips.finish.submit', $trip) }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="km_akhir_display" class="form-label">Odometer Akhir (KM) <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('km_akhir') is-invalid @enderror" 
                               id="km_akhir_display" 
                               placeholder="contoh: 1.500" inputmode="numeric" autocomplete="off" required>
                        <input type="hidden" id="km_akhir" name="km_akhir" value="{{ old('km_akhir') }}">
                        <small class="text-muted">KM Awal: {{ number_format($trip->km_awal, 0, ',', '.') }} | Masukkan angka odometer. Akan diformat otomatis.</small>
                        @error('km_akhir')
                            <div class="invalid-feedback d-block">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="jam_in" class="form-label">Waktu Kembali <span class="text-danger">*</span></label>
                        <input type="datetime-local" class="form-control @error('jam_in') is-invalid @enderror" 
                               id="jam_in" name="jam_in" value="{{ old('jam_in') }}" required>
                        <small class="text-muted">Berangkat: {{ $trip->jam_out->format('d M Y H:i') }}</small>
                        @error('jam_in')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="foto_akhir" class="form-label">Foto Akhir <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('foto_akhir') is-invalid @enderror" 
                               id="foto_akhir" name="foto_akhir" accept="image/*" capture="environment" required>
                        <small class="text-muted d-block mt-1">
                            Ambil foto dashboard mobil setelah perjalanan selesai (akan dikompresi otomatis sebelum diupload).
                        </small>
                        @error('foto_akhir')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <div class="mt-2">
                            <img id="preview_foto_akhir" src="" alt="Pratinjau" class="img-thumbnail" style="max-width: 300px; display: none;">
                        </div>
                        <div id="compression_status_akhir" class="mt-2" style="display: none;">
                            <small class="text-info">
                                <i class="bi bi-hourglass-split"></i> Mengkompresi gambar...
                            </small>
                        </div>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle"></i> Selesaikan Perjalanan
                        </button>
                        <a href="{{ route('driver.trips.show', $trip) }}" class="btn btn-secondary">
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
    // Setup auto-format ribuan dengan hidden input untuk km_akhir
    (function() {
        const displayInput = document.getElementById('km_akhir_display');
        const hiddenInput = document.getElementById('km_akhir');
        
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
    
    // Handle image compression and preview for foto_akhir
    document.getElementById('foto_akhir').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            handleImageCompressionAkhir(file, e.target);
        }
    });

    function handleImageCompressionAkhir(file, inputElement) {
        // Show compression status
        const statusDiv = document.getElementById('compression_status_akhir');
        const preview = document.getElementById('preview_foto_akhir');
        
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
