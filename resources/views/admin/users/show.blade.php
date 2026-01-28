@extends('layouts.admin')

@section('title', 'Detail User: ' . $user->name)
@section('page-title', 'Detail User')

@section('content')
<div class="row">
    <!-- User Info -->
    <div class="col-md-4 mb-4">
        <div class="card">
            <div class="card-body text-center">
                <div class="mb-3">
                    <i class="bi bi-person-circle" style="font-size: 5rem; color: #666;"></i>
                </div>
                <h4>{{ $user->name }}</h4>
                <p class="text-muted">{{ $user->email }}</p>
                <p>
                    @if($user->isAdmin())
                        <span class="badge badge-admin fs-6">Admin</span>
                    @else
                        <span class="badge badge-user fs-6">User</span>
                    @endif
                </p>

                <hr>

                <div class="text-start">
                    <p class="mb-2">
                        <strong><i class="bi bi-calendar"></i> Terdaftar:</strong><br>
                        {{ $user->created_at->format('d M Y, H:i') }}
                    </p>
                    <p class="mb-2">
                        <strong><i class="bi bi-heart"></i> Total Favorit:</strong><br>
                        {{ $user->favoriteFilms->count() }} film
                    </p>
                </div>

                <hr>

                <div class="d-grid gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                    @if(!$user->isAdmin() && $user->id !== auth()->id())
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST"
                          onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Hapus User
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <!-- Favorite Films -->
    <div class="col-md-8 mb-4">
        <div class="card">
            <div class="card-header">
                <h6 class="mb-0"><i class="bi bi-heart"></i> Film Favorit User</h6>
            </div>
            <div class="card-body">
                @if($user->favoriteFilms->count() > 0)
                <div class="table-responsive">
                    <table class="table table-dark table-hover">
                        <thead>
                            <tr>
                                <th>Film</th>
                                <th>Status</th>
                                <th>Rating</th>
                                <th>Ditambahkan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($user->favoriteFilms as $favorite)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        @if($favorite->poster_path)
                                            <img src="https://image.tmdb.org/t/p/w92{{ $favorite->poster_path }}"
                                                 alt="{{ $favorite->title }}" class="rounded me-2"
                                                 style="width: 40px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="rounded me-2 d-flex align-items-center justify-content-center"
                                                 style="width: 40px; height: 60px; background: #333;">
                                                <i class="bi bi-film"></i>
                                            </div>
                                        @endif
                                        <div>
                                            <strong>{{ $favorite->title }}</strong>
                                            <br>
                                            <small class="text-muted">
                                                {{ $favorite->release_date ? $favorite->release_date->format('Y') : 'N/A' }}
                                            </small>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @switch($favorite->watch_status)
                                        @case('want_to_watch')
                                            <span class="badge bg-info">Ingin Ditonton</span>
                                            @break
                                        @case('watching')
                                            <span class="badge bg-warning">Sedang Ditonton</span>
                                            @break
                                        @case('watched')
                                            <span class="badge bg-success">Sudah Ditonton</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    @if($favorite->rating)
                                        <span class="text-warning">
                                            <i class="bi bi-star-fill"></i> {{ $favorite->rating }}/10
                                        </span>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>{{ $favorite->created_at->format('d M Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="text-center py-4">
                    <i class="bi bi-heart" style="font-size: 3rem; color: #666;"></i>
                    <h5 class="mt-3">Belum ada film favorit</h5>
                    <p class="text-muted">User ini belum menambahkan film ke favorit</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    .badge-admin {
        background-color: var(--primary-color);
    }

    .badge-user {
        background-color: #6c757d;
    }
</style>
@endpush
@endsection
