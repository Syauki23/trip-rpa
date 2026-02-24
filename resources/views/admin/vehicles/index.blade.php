@extends('layouts.app')

@section('title', 'Kendaraan - Admin')

@section('content')
<!-- Mobile Section Title -->
<div class="mobile-only mobile-section-title">
    <i class="bi bi-car-front me-2"></i>Manajemen Kendaraan
</div>

<!-- Desktop Header -->
<div class="d-flex justify-content-between align-items-center mb-4 desktop-only">
    <h2><i class="bi bi-car-front"></i> Manajemen Kendaraan</h2>
    <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Kendaraan
    </a>
</div>

<!-- Desktop Card -->
<div class="card desktop-only">
    <div class="card-body">
        @if($vehicles->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Nomor Plat</th>
                            <th>Status</th>
                            <th>Dibuat Pada</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($vehicles as $vehicle)
                        <tr>
                            <td>{{ $vehicle->id }}</td>
                            <td>{{ $vehicle->name }}</td>
                            <td><span class="badge bg-secondary">{{ $vehicle->plate_number }}</span></td>
                            <td>
                                @if($vehicle->status === 'available')
                                    <span class="badge bg-success">Tersedia</span>
                                @elseif($vehicle->status === 'in_use')
                                    <span class="badge bg-warning">Digunakan</span>
                                @else
                                    <span class="badge bg-danger">Maintenance</span>
                                @endif
                            </td>
                            <td>{{ $vehicle->created_at->format('d M Y') }}</td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" 
                                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $vehicles->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-car-front text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Tidak ada kendaraan. Tambahkan kendaraan pertama Anda!</p>
                <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kendaraan
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Mobile List View -->
<div class="mobile-only mobile-list-view">
    @if($vehicles->count() > 0)
        @foreach($vehicles as $vehicle)
        <div class="mobile-list-item">
            <div class="item-header">
                <div>
                    <div class="item-title">
                        <i class="bi bi-car-front-fill text-primary me-1"></i>
                        {{ $vehicle->name }}
                    </div>
                    <div class="item-subtitle">
                        <span class="badge bg-secondary">{{ $vehicle->plate_number }}</span>
                    </div>
                </div>
                <div>
                    @if($vehicle->status === 'available')
                        <span class="badge bg-success">Tersedia</span>
                    @elseif($vehicle->status === 'in_use')
                        <span class="badge bg-warning">Digunakan</span>
                    @else
                        <span class="badge bg-danger">Maintenance</span>
                    @endif
                </div>
            </div>
            
            <div class="item-meta">
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ $vehicle->created_at->format('d M Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-hash"></i>
                    <span>ID: {{ $vehicle->id }}</span>
                </div>
            </div>
            
            <div class="item-actions">
                <a href="{{ route('admin.vehicles.edit', $vehicle) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                <form action="{{ route('admin.vehicles.destroy', $vehicle) }}" method="POST" class="flex-fill" 
                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus kendaraan ini?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm w-100">
                        <i class="bi bi-trash"></i> Hapus
                    </button>
                </form>
            </div>
        </div>
        @endforeach
        
        <div class="mt-3">
            {{ $vehicles->links() }}
        </div>
    @else
        <div class="mobile-empty-state">
            <i class="bi bi-car-front"></i>
            <h5>Belum Ada Kendaraan</h5>
            <p>Tambahkan kendaraan pertama Anda</p>
            <a href="{{ route('admin.vehicles.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Tambah Kendaraan
            </a>
        </div>
    @endif
</div>

<!-- Floating Action Button -->
<a href="{{ route('admin.vehicles.create') }}" class="fab mobile-only">
    <i class="bi bi-plus-lg"></i>
</a>
@endsection
