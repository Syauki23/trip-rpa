<div class="row">
    <div class="col-md-6">
        <h5 class="mb-3">Informasi Perjalanan</h5>
        <table class="table table-bordered">
            <tr>
                <th width="40%">ID Perjalanan</th>
                <td>#{{ $trip->id }}</td>
            </tr>
            <tr>
                <th>Nama Sopir</th>
                <td>{{ $trip->driver_name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Input By</th>
                <td>{{ $trip->driver->name ?? '-' }}</td>
            </tr>
            <tr>
                <th>Kendaraan</th>
                <td>
                    {{ $trip->vehicle->name }}<br>
                    <span class="badge bg-secondary">{{ $trip->vehicle->plate_number }}</span>
                </td>
            </tr>
            <tr>
                <th>Tujuan</th>
                <td>{{ $trip->tujuan }}</td>
            </tr>
            <tr>
                <th>Keperluan</th>
                <td>{{ $trip->keperluan }}</td>
            </tr>
            <tr>
                <th>Petugas 1</th>
                <td>
                    @if($trip->petugas_1)
                        {{ $trip->petugas_1 }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Petugas 2</th>
                <td>
                    @if($trip->petugas_2)
                        {{ $trip->petugas_2 }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{!! $trip->status_badge !!}</td>
            </tr>
        </table>
    </div>

    <div class="col-md-6">
        <h5 class="mb-3">Detail Perjalanan</h5>
        <table class="table table-bordered">
            <tr>
                <th width="40%">Waktu Berangkat</th>
                <td>{{ $trip->jam_out->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Waktu Kembali</th>
                <td>
                    @if($trip->jam_in)
                        {{ $trip->jam_in->format('d M Y H:i') }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>KM Awal</th>
                <td>{{ number_format($trip->km_awal) }} km</td>
            </tr>
            <tr>
                <th>KM Akhir</th>
                <td>
                    @if($trip->km_akhir)
                        {{ number_format($trip->km_akhir) }} km
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Total Jarak</th>
                <td>
                    @if($trip->total_km)
                        <strong>{{ number_format($trip->total_km) }} km</strong>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Dibuat Pada</th>
                <td>{{ $trip->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <h5 class="mb-3">Foto Awal</h5>
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $trip->foto_awal) }}" 
                     alt="Foto Awal" 
                     class="img-fluid rounded"
                     style="max-height: 400px; object-fit: contain;">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <h5 class="mb-3">Foto Akhir</h5>
        <div class="card">
            <div class="card-body text-center">
                @if($trip->foto_akhir)
                    <img src="{{ asset('storage/' . $trip->foto_akhir) }}" 
                         alt="Foto Akhir" 
                         class="img-fluid rounded"
                         style="max-height: 400px; object-fit: contain;">
                @else
                    <div class="text-muted py-5">
                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                        <p class="mt-3">Belum ada foto akhir</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
