<div class="row">
    <div class="col-md-6">
        <h5 class="mb-3">Trip Information</h5>
        <table class="table table-bordered">
            <tr>
                <th width="40%">Trip ID</th>
                <td>#{{ $trip->id }}</td>
            </tr>
            <tr>
                <th>Driver</th>
                <td>{{ $trip->driver->name }}</td>
            </tr>
            <tr>
                <th>Vehicle</th>
                <td>
                    {{ $trip->vehicle->name }}<br>
                    <span class="badge bg-secondary">{{ $trip->vehicle->plate_number }}</span>
                </td>
            </tr>
            <tr>
                <th>Destination</th>
                <td>{{ $trip->tujuan }}</td>
            </tr>
            <tr>
                <th>Purpose</th>
                <td>{{ $trip->keperluan }}</td>
            </tr>
            <tr>
                <th>Status</th>
                <td>{!! $trip->status_badge !!}</td>
            </tr>
        </table>
    </div>

    <div class="col-md-6">
        <h5 class="mb-3">Trip Details</h5>
        <table class="table table-bordered">
            <tr>
                <th width="40%">Departure Time</th>
                <td>{{ $trip->jam_out->format('d M Y H:i') }}</td>
            </tr>
            <tr>
                <th>Return Time</th>
                <td>
                    @if($trip->jam_in)
                        {{ $trip->jam_in->format('d M Y H:i') }}
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Starting KM</th>
                <td>{{ number_format($trip->km_awal) }} km</td>
            </tr>
            <tr>
                <th>Ending KM</th>
                <td>
                    @if($trip->km_akhir)
                        {{ number_format($trip->km_akhir) }} km
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Total Distance</th>
                <td>
                    @if($trip->total_km)
                        <strong>{{ number_format($trip->total_km) }} km</strong>
                    @else
                        <span class="text-muted">-</span>
                    @endif
                </td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $trip->created_at->format('d M Y H:i') }}</td>
            </tr>
        </table>
    </div>
</div>

<div class="row mt-4">
    <div class="col-md-6">
        <h5 class="mb-3">Starting Photo</h5>
        <div class="card">
            <div class="card-body text-center">
                <img src="{{ asset('storage/' . $trip->foto_awal) }}" 
                     alt="Starting Photo" 
                     class="img-fluid rounded"
                     style="max-height: 400px; object-fit: contain;">
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <h5 class="mb-3">Ending Photo</h5>
        <div class="card">
            <div class="card-body text-center">
                @if($trip->foto_akhir)
                    <img src="{{ asset('storage/' . $trip->foto_akhir) }}" 
                         alt="Ending Photo" 
                         class="img-fluid rounded"
                         style="max-height: 400px; object-fit: contain;">
                @else
                    <div class="text-muted py-5">
                        <i class="bi bi-image" style="font-size: 3rem;"></i>
                        <p class="mt-3">No ending photo yet</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
