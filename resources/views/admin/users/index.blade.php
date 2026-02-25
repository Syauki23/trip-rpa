@extends('layouts.app')

@section('title', 'Manajemen Akun - Admin')

@section('content')
<!-- Mobile Section Title -->
<div class="mobile-only mobile-section-title">
    <i class="bi bi-people me-2"></i>Manajemen Akun
</div>

<!-- Desktop Header -->
<div class="d-flex justify-content-between align-items-center mb-4 desktop-only">
    <h2><i class="bi bi-people"></i> Manajemen Akun</h2>
    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
        <i class="bi bi-plus-circle"></i> Tambah Akun
    </a>
</div>

<!-- Desktop Card -->
<div class="card desktop-only">
    <div class="card-body">
        @if($users->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td><code>{{ $user->username }}</code></td>
                            <td>{{ $user->email ?? '-' }}</td>
                            <td>
                                @if($user->role->name === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @elseif($user->role->name === 'supervisor')
                                    <span class="badge bg-warning">Supervisor</span>
                                @else
                                    <span class="badge bg-info">Driver</span>
                                @endif
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-pencil"></i>
                                    </a>
                                    @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" 
                                              onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-outline-danger">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    @else
                                        <button type="button" class="btn btn-outline-secondary" disabled title="Tidak dapat menghapus akun sendiri">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-3">
                {{ $users->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3">Belum ada akun. Tambahkan akun pertama!</p>
                <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Akun
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Mobile List View -->
<div class="mobile-only mobile-list-view">
    @if($users->count() > 0)
        @foreach($users as $user)
        <div class="mobile-list-item">
            <div class="item-header">
                <div>
                    <div class="item-title">
                        <i class="bi bi-person-circle text-primary me-1"></i>
                        {{ $user->name }}
                    </div>
                    <div class="item-subtitle">
                        <code>{{ $user->username }}</code>
                        @if($user->email)
                            • {{ $user->email }}
                        @endif
                    </div>
                </div>
                <div>
                    @if($user->role->name === 'admin')
                        <span class="badge bg-danger">Admin</span>
                    @elseif($user->role->name === 'supervisor')
                        <span class="badge bg-warning">Supervisor</span>
                    @else
                        <span class="badge bg-info">Driver</span>
                    @endif
                </div>
            </div>
            
            <div class="item-meta">
                <div class="meta-item">
                    <i class="bi bi-calendar3"></i>
                    <span>{{ $user->created_at->format('d M Y') }}</span>
                </div>
                <div class="meta-item">
                    <i class="bi bi-hash"></i>
                    <span>ID: {{ $user->id }}</span>
                </div>
            </div>
            
            <div class="item-actions">
                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-primary btn-sm flex-fill">
                    <i class="bi bi-pencil"></i> Edit
                </a>
                @if($user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="flex-fill" 
                          onsubmit="return confirm('Apakah Anda yakin ingin menghapus akun ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm w-100">
                            <i class="bi bi-trash"></i> Hapus
                        </button>
                    </form>
                @else
                    <button type="button" class="btn btn-secondary btn-sm flex-fill" disabled>
                        <i class="bi bi-lock"></i> Akun Sendiri
                    </button>
                @endif
            </div>
        </div>
        @endforeach
        
        <div class="mt-3">
            {{ $users->links() }}
        </div>
    @else
        <div class="mobile-empty-state">
            <i class="bi bi-people"></i>
            <h5>Belum Ada Akun</h5>
            <p>Tambahkan akun pertama</p>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-lg">
                <i class="bi bi-plus-circle"></i> Tambah Akun
            </a>
        </div>
    @endif
</div>

<!-- Floating Action Button -->
<a href="{{ route('admin.users.create') }}" class="fab mobile-only">
    <i class="bi bi-plus-lg"></i>
</a>
@endsection
