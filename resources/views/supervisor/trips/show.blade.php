@extends('layouts.app')

@section('title', 'Detail Perjalanan - Supervisor')

@section('content')
<div class="mb-4">
    <a href="{{ route('supervisor.trips.index') }}" class="btn btn-outline-secondary">
        <i class="bi bi-arrow-left"></i> Kembali
    </a>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="mb-0"><i class="bi bi-file-text"></i> Detail Perjalanan #{{ $trip->id }}</h4>
                <div>
                    <a href="{{ route('supervisor.trips.edit', $trip) }}" class="btn btn-warning me-2">
                        <i class="bi bi-pencil"></i> Edit
                    </a>
                    <form action="{{ route('supervisor.trips.destroy', $trip) }}" 
                          method="POST" 
                          class="d-inline me-2"
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus perjalanan ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                    @if($trip->status === 'pending')
                        <form action="{{ route('supervisor.trips.approve', $trip) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-success" 
                                    onclick="return confirm('Setujui perjalanan ini?')">
                                <i class="bi bi-check-circle"></i> Setujui
                            </button>
                        </form>
                    @elseif($trip->status === 'completed')
                        <form action="{{ route('supervisor.trips.verify', $trip) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-dark" 
                                    onclick="return confirm('Verifikasi perjalanan ini?')">
                                <i class="bi bi-patch-check"></i> Verifikasi
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
