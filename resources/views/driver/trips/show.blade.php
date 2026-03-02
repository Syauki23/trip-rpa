@extends('layouts.app')

@section('title', 'Detail Perjalanan - Driver')

@section('content')
<div class="mb-4">
    <a href="{{ route('driver.trips.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-text"></i> Detail Perjalanan #{{ $trip->id }}</h4>
                <div>
                    @if($trip->status === 'ongoing')
                        <a href="{{ route('driver.trips.edit', $trip) }}" class="btn btn-warning me-2">
                            <i class="bi bi-pencil"></i> Edit
                        </a>
                        <a href="{{ route('driver.trips.finish', $trip) }}" class="btn btn-success">
                            <i class="bi bi-stop-circle"></i> Selesaikan Perjalanan
                        </a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @include('partials.trip-detail', ['trip' => $trip])
            </div>
        </div>
    </div>
</div>
@endsection
