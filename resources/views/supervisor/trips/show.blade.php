@extends('layouts.app')

@section('title', 'Trip Details - Supervisor')

@section('content')
<div class="mb-4">
    <a href="{{ route('supervisor.trips.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-text"></i> Trip Details #{{ $trip->id }}</h4>
                <div>
                    @if($trip->status === 'pending')
                        <form action="{{ route('supervisor.trips.approve', $trip) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('Approve this trip?')">
                                <i class="bi bi-check-circle"></i> Approve Trip
                            </button>
                        </form>
                    @elseif($trip->status === 'completed')
                        <form action="{{ route('supervisor.trips.verify', $trip) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-dark" 
                                    onclick="return confirm('Verify this trip?')">
                                <i class="bi bi-patch-check"></i> Verify Trip
                            </button>
                        </form>
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
