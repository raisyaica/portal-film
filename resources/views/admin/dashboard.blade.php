@extends('layouts.admin')

@section('title', 'Dashboard Admin')
@section('page-title', 'Dashboard')

@section('content')
<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon text-primary"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ $totalUsers }}</div>
            <div class="stat-label">Total User</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon text-danger"><i class="bi bi-person-badge"></i></div>
            <div class="stat-value">{{ $totalAdmins }}</div>
            <div class="stat-label">Total Admin</div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="stat-card">
            <div class="stat-icon text-warning"><i class="bi bi-heart"></i></div>
            <div class="stat-value">{{ $totalFavorites }}</div>
            <div class="stat-label">Total Film Favorit</div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Users -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="mb-0"><i class="bi bi-people"></i> User Terbaru</h6>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-outline-primary">Lihat Semua</a>
            </div>
            <div class="card-body">
                @if($recentUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover mb-0">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Terdaftar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentUsers as $user)
                            <tr>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->created_at->diffForHumans() }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <p class="text-muted text-center mb-0">Belum ada user terdaftar</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Popular Favorites -->
    <div class="col-md-6 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-fire"></i> Film Terpopuler di Favorit</h6>
            </div>
            <div class="card-body">
                @if($popularFavorites->count() > 0)
                <div class="list-group list-group-flush">
                    @foreach($popularFavorites as $film)
                    <div class="list-group-item d-flex align-items-center" style="background-color: transparent; border-color: #333;">
                        @if($film->poster_path)
                            <img src="https://image.tmdb.org/t/p/w92{{ $film->poster_path }}"
                                 alt="{{ $film->title }}" class="rounded me-3" style="width: 50px; height: 75px; object-fit: cover;">
                        @else
                            <div class="rounded me-3 d-flex align-items-center justify-content-center" style="width: 50px; height: 75px; background: #333;">
                                <i class="bi bi-film"></i>
                            </div>
                        @endif
                        <div class="flex-grow-1">
                            <h6 class="mb-1">{{ $film->title }}</h6>
                            <small class="text-muted">
                                <i class="bi bi-heart-fill text-danger"></i> {{ $film->total }} user
                            </small>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <p class="text-muted text-center mb-0">Belum ada film di favorit</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="card">
    <div class="card-header">
        <h6 class="mb-0"><i class="bi bi-lightning"></i> Aksi Cepat</h6>
    </div>
    <div class="card-body">
        <div class="d-flex gap-2 flex-wrap">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary">
                <i class="bi bi-people"></i> Kelola User
            </a>
            <a href="{{ route('home') }}" class="btn btn-outline-primary">
                <i class="bi bi-house"></i> Lihat Website
            </a>
        </div>
    </div>
</div>
@endsection
