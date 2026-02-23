@extends('layouts.app')

@section('title', 'Trip Details - Admin')

@section('content')
<div class="mb-4">
    <a href="{{ route('admin.trips.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Back
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h4 class="mb-0"><i class="bi bi-file-text"></i> Trip Details #{{ $trip->id }}</h4>
            </div>
            <div class="card-body">
                @include('partials.trip-detail', ['trip' => $trip])
            </div>
        </div>
    </div>
</div>
@endsection
