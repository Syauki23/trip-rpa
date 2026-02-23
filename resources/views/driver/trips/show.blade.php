@extends('layouts.app')

@section('title', 'Trip Details - Driver')

@section('content')
<div class="mb-4">
    <a href="{{ route('driver.trips.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-text"></i> Trip Details #{{ $trip->id }}</h4>
                <div>
                    @if($trip->status === 'approved')
                        <form action="{{ route('driver.trips.start', $trip) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary" 
                                    onclick="return confirm('Start this trip?')">
                                <i class="bi bi-play-circle"></i> Start Trip
                            </button>
                        </form>
                    @elseif($trip->status === 'ongoing')
                        <a href="{{ route('driver.trips.finish', $trip) }}" class="btn btn-success">
                            <i class="bi bi-stop-circle"></i> Finish Trip
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
