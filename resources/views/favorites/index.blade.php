@extends('layouts.app')

@section('title', 'Koleksi Favorit Saya')

@section('content')
<div class="container py-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-heart-fill text-danger"></i> Koleksi Favorit Saya</h2>
            <p class="text-muted mb-0">{{ $favorites->total() }} film dalam koleksi Anda</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="bi bi-plus-circle"></i> Tambah Film
        </a>
    </div>

    <!-- Filter -->
    <div class="card mb-4">
        <div class="card-body">
            <form action="{{ route('favorites.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter Status</label>
                    <select class="form-select" id="status" name="status">
                        <option value="">Semua Status</option>
                        @foreach($statuses as $key => $label)
                            <option value="{{ $key }}" {{ $currentStatus == $key ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if($favorites->count() > 0)
        <div class="row">
            @foreach($favorites as $favorite)
            <div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
                <div class="movie-card card h-100 position-relative">
                    <!-- Status Badge -->
                    <div class="position-absolute top-0 start-0 m-2" style="z-index: 10;">
                        @switch($favorite->watch_status)
                            @case('want_to_watch')
                                <span class="badge bg-info"><i class="bi bi-bookmark"></i></span>
                                @break
                            @case('watching')
                                <span class="badge bg-warning"><i class="bi bi-play-circle"></i></span>
                                @break
                            @case('watched')
                                <span class="badge bg-success"><i class="bi bi-check-circle"></i></span>
                                @break
                        @endswitch
                    </div>

                    <!-- Actions -->
                    <div class="position-absolute top-0 end-0 m-2 btn-group-vertical" style="z-index: 10;">
                        <a href="{{ route('favorites.edit', $favorite->id) }}" class="btn btn-sm btn-outline-light" title="Edit">
                            <i class="bi bi-pencil"></i>
                        </a>
                        <form action="{{ route('favorites.destroy', $favorite->id) }}" method="POST" onsubmit="return confirm('Hapus film ini dari favorit?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                <i class="bi bi-trash"></i>
                            </button>
                        </form>
                    </div>

                    <a href="{{ route('film.show', $favorite->tmdb_id) }}" class="text-decoration-none">
                        @if($favorite->poster_path)
                            <img src="https://image.tmdb.org/t/p/w500{{ $favorite->poster_path }}" class="card-img-top" alt="{{ $favorite->title }}" loading="lazy">
                        @else
                            <div class="no-poster">
                                <i class="bi bi-film" style="font-size: 3rem;"></i>
                            </div>
                        @endif

                        <div class="card-body">
                            <h6 class="card-title" title="{{ $favorite->title }}">{{ $favorite->title }}</h6>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="rating">
                                    <i class="bi bi-star-fill"></i>
                                    {{ number_format($favorite->vote_average, 1) }}
                                </span>
                                <span class="release-date">
                                    {{ $favorite->release_date ? $favorite->release_date->format('Y') : 'N/A' }}
                                </span>
                            </div>

                            @if($favorite->rating)
                            <div class="mt-2 small">
                                <span class="text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star{{ $i <= ceil($favorite->rating / 2) ? '-fill' : '' }}"></i>
                                    @endfor
                                </span>
                            </div>
                            @endif
                        </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $favorites->appends(['status' => $currentStatus])->links() }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-heart" style="font-size: 4rem; color: var(--text-muted);"></i>
            <h4 class="mt-3">Koleksi favorit kosong</h4>
            <p class="text-muted">
                @if($currentStatus)
                    Tidak ada film dengan status "{{ $statuses[$currentStatus] ?? $currentStatus }}"
                @else
                    Anda belum menambahkan film ke koleksi favorit
                @endif
            </p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="bi bi-film"></i> Jelajahi Film
            </a>
        </div>
    @endif
</div>

@push('styles')
<style>
    .movie-card .btn-group-vertical {
        opacity: 0;
        transition: opacity 0.3s;
    }

    .movie-card:hover .btn-group-vertical {
        opacity: 1;
    }

    .pagination .page-link {
        background-color: var(--card-bg);
        border-color: #333;
        color: var(--text-light);
    }

    .pagination .page-link:hover {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-color);
        border-color: var(--primary-color);
    }

    .pagination .page-item.disabled .page-link {
        background-color: #1a1a1a;
        border-color: #333;
        color: #666;
    }
</style>
@endpush
@endsection
