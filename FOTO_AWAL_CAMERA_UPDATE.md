# 📷 Update: Foto Awal Wajib dari Kamera

## ✅ Perubahan yang Dilakukan

### File yang Diubah
- `resources/views/driver/trips/create.blade.php`

### Perubahan Detail

#### Sebelum:
```html
<input type="file" class="form-control @error('foto_awal') is-invalid @enderror" 
       id="foto_awal" name="foto_awal" accept="image/*" required>
```

#### Sesudah:
```html
<input type="file" class="form-control @error('foto_awal') is-invalid @enderror" 
       id="foto_awal" name="foto_awal" accept="image/*" capture="environment" required>
<small class="text-muted d-block mt-1">
    Foto dashboard mobil yang terlihat KM (harus diambil langsung dari kamera).
</small>
```

## 🎯 Fitur Baru

### 1. Atribut `capture="environment"`
- **Fungsi**: Memaksa HP untuk langsung membuka kamera belakang
- **Behavior**: User tidak bisa memilih foto dari galeri
- **Platform Support**:
  - ✅ Android: Langsung buka kamera
  - ✅ iOS: Langsung buka kamera
  - ⚠️ Desktop: Tetap bisa pilih file (karena tidak ada kamera belakang)

### 2. Keterangan Tambahan
- **Text**: "Foto dashboard mobil yang terlihat KM (harus diambil langsung dari kamera)."
- **Style**: `text-muted` (abu-abu), `d-block` (block display), `mt-1` (margin top)
- **Posisi**: Di bawah input file, sebelum error message

## 📱 Cara Kerja di Mobile

### Android
```
User tap input file
    ↓
HP langsung buka kamera belakang
    ↓
User ambil foto dashboard
    ↓
Foto langsung ter-upload ke form
    ↓
Preview muncul di bawah
```

### iOS
```
User tap input file
    ↓
HP langsung buka kamera belakang
    ↓
User ambil foto dashboard
    ↓
Foto langsung ter-upload ke form
    ↓
Preview muncul di bawah
```

### Desktop (Fallback)
```
User klik input file
    ↓
Browser buka file picker
    ↓
User pilih file gambar
    ↓
File ter-upload ke form
    ↓
Preview muncul di bawah
```

## 🔒 Validasi

### Frontend (HTML5)
- `accept="image/*"` - Hanya terima file gambar
- `capture="environment"` - Wajib dari kamera belakang (mobile)
- `required` - Field wajib diisi

### Backend (Tidak Diubah)
- Validasi di controller tetap sama
- Upload logic tetap sama
- Storage path tetap sama
- Nama field tetap `foto_awal`

## 📋 Checklist Testing

### Mobile Testing
- [ ] Buka form di HP Android
- [ ] Tap input "Foto Awal"
- [ ] Pastikan kamera langsung terbuka (tidak ada pilihan galeri)
- [ ] Ambil foto dashboard
- [ ] Pastikan foto ter-upload
- [ ] Pastikan preview muncul
- [ ] Submit form
- [ ] Pastikan foto tersimpan di database

### iOS Testing
- [ ] Buka form di iPhone/iPad
- [ ] Tap input "Foto Awal"
- [ ] Pastikan kamera langsung terbuka
- [ ] Ambil foto dashboard
- [ ] Pastikan foto ter-upload
- [ ] Pastikan preview muncul
- [ ] Submit form
- [ ] Pastikan foto tersimpan di database

### Desktop Testing (Fallback)
- [ ] Buka form di desktop browser
- [ ] Klik input "Foto Awal"
- [ ] File picker terbuka (normal behavior)
- [ ] Pilih file gambar
- [ ] Pastikan preview muncul
- [ ] Submit form
- [ ] Pastikan foto tersimpan di database

## 🎨 Tampilan

### Light Mode
```
┌─────────────────────────────────────────┐
│ Foto Awal *                             │
│ ┌─────────────────────────────────────┐ │
│ │ [Choose File] No file chosen        │ │
│ └─────────────────────────────────────┘ │
│ Foto dashboard mobil yang terlihat KM   │
│ (harus diambil langsung dari kamera).   │
│                                         │
│ [Preview Image]                         │
└─────────────────────────────────────────┘
```

### Dark Mode
```
┌─────────────────────────────────────────┐
│ Foto Awal *                             │
│ ┌─────────────────────────────────────┐ │
│ │ [Choose File] No file chosen        │ │
│ └─────────────────────────────────────┘ │
│ Foto dashboard mobil yang terlihat KM   │
│ (harus diambil langsung dari kamera).   │
│                                         │
│ [Preview Image]                         │
└─────────────────────────────────────────┘
```

## 🚫 Yang TIDAK Diubah

✅ Tidak ada perubahan pada:
- `app/Http/Controllers/Driver/TripController.php` (Controller)
- `app/Http/Requests/*` (Request validation)
- `app/Models/Trip.php` (Model)
- `routes/web.php` (Routes)
- Upload logic
- Storage path
- Database schema
- Nama field (`foto_awal`)

❌ Hanya perubahan pada:
- Blade template (HTML)
- Atribut input file
- Keterangan text

## 📖 HTML Attributes Reference

### `accept="image/*"`
- **Fungsi**: Filter file type, hanya terima gambar
- **Format**: image/jpeg, image/png, image/gif, dll
- **Browser Support**: ✅ Semua browser modern

### `capture="environment"`
- **Fungsi**: Buka kamera belakang langsung (mobile)
- **Values**:
  - `user` - Kamera depan (selfie)
  - `environment` - Kamera belakang
- **Browser Support**: 
  - ✅ Chrome Android
  - ✅ Safari iOS
  - ⚠️ Desktop (ignored)

### `required`
- **Fungsi**: Field wajib diisi
- **Validation**: HTML5 native validation
- **Browser Support**: ✅ Semua browser modern

## 💡 Tips untuk User

1. **Pastikan pencahayaan cukup** - Foto dashboard harus jelas
2. **Fokus pada odometer** - KM harus terlihat jelas
3. **Hindari blur** - Tangan harus stabil saat foto
4. **Cek preview** - Pastikan foto sudah benar sebelum submit

## 🔧 Troubleshooting

### Kamera tidak terbuka di mobile
- **Penyebab**: Browser tidak support `capture` attribute
- **Solusi**: Update browser ke versi terbaru

### Masih bisa pilih dari galeri
- **Penyebab**: Browser desktop atau browser lama
- **Solusi**: Normal behavior, tidak ada masalah

### Preview tidak muncul
- **Penyebab**: JavaScript error atau file terlalu besar
- **Solusi**: Check console, pastikan file < 5MB

### Error saat upload
- **Penyebab**: File terlalu besar atau format tidak didukung
- **Solusi**: Check validasi backend, pastikan format image/*

## 📊 Browser Compatibility

| Browser | Version | `capture` Support |
|---------|---------|-------------------|
| Chrome Android | 53+ | ✅ Full Support |
| Safari iOS | 11+ | ✅ Full Support |
| Firefox Android | 79+ | ✅ Full Support |
| Chrome Desktop | Any | ⚠️ Ignored (fallback to file picker) |
| Safari Desktop | Any | ⚠️ Ignored (fallback to file picker) |
| Firefox Desktop | Any | ⚠️ Ignored (fallback to file picker) |

## 🎯 Expected Behavior

### Mobile (Primary Use Case)
1. User tap "Foto Awal" input
2. Camera app opens immediately
3. User takes photo of dashboard
4. Photo is captured and uploaded
5. Preview shows below input
6. User can submit form

### Desktop (Fallback)
1. User clicks "Foto Awal" input
2. File picker opens
3. User selects image file
4. File is uploaded
5. Preview shows below input
6. User can submit form

---

**Update Version**: 1.0.0  
**Date**: 2026-02-24  
**File Changed**: `resources/views/driver/trips/create.blade.php`  
**Lines Changed**: 1 (added `capture="environment"` + keterangan)  
**Impact**: Frontend only, no backend changes
