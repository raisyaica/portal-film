@extends('layouts.app')

@section('title', $movie['title'])

@section('content')
@php
    $backdropUrl = $movie['backdrop_path']
        ? 'https://image.tmdb.org/t/p/original' . $movie['backdrop_path']
        : null;
    $posterUrl = $movie['poster_path']
        ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path']
        : null;
@endphp

<!-- Backdrop Section -->
<div class="position-relative" style="min-height: 500px;">
    @if($backdropUrl)
    <div style="position: absolute; top: 0; left: 0; right: 0; bottom: 0;
                background: linear-gradient(rgba(20, 20, 20, 0.3), rgba(20, 20, 20, 1)),
                            url('{{ $backdropUrl }}');
                background-size: cover;
                background-position: center top;">
    </div>
    @endif

    <div class="container position-relative py-5">
        <div class="row">
            <!-- Poster -->
            <div class="col-md-4 mb-4">
                @if($posterUrl)
                    <img src="{{ $posterUrl }}" alt="{{ $movie['title'] }}" class="img-fluid rounded shadow" style="max-width: 300px;">
                @else
                    <div class="no-poster rounded" style="height: 450px; max-width: 300px;">
                        <i class="bi bi-film" style="font-size: 5rem;"></i>
                    </div>
                @endif
            </div>

            <!-- Movie Info -->
            <div class="col-md-8">
                <h1 class="fw-bold mb-2">{{ $movie['title'] }}</h1>

                @if($movie['original_title'] !== $movie['title'])
                <p class="text-muted">{{ $movie['original_title'] }}</p>
                @endif

                <!-- Meta Info -->
                <div class="d-flex flex-wrap gap-3 mb-4">
                    <span class="badge bg-warning text-dark fs-6">
                        <i class="bi bi-star-fill"></i> {{ number_format($movie['vote_average'], 1) }}/10
                    </span>
                    <span class="badge bg-secondary fs-6">
                        <i class="bi bi-people"></i> {{ number_format($movie['vote_count']) }} votes
                    </span>
                    @if(isset($movie['release_date']) && $movie['release_date'])
                    <span class="badge bg-info fs-6">
                        <i class="bi bi-calendar"></i> {{ \Carbon\Carbon::parse($movie['release_date'])->format('d M Y') }}
                    </span>
                    @endif
                    @if(isset($movie['runtime']) && $movie['runtime'])
                    <span class="badge bg-secondary fs-6">
                        <i class="bi bi-clock"></i> {{ floor($movie['runtime'] / 60) }}j {{ $movie['runtime'] % 60 }}m
                    </span>
                    @endif
                </div>

                <!-- Genres -->
                @if(isset($movie['genres']) && count($movie['genres']) > 0)
                <div class="mb-4">
                    @foreach($movie['genres'] as $genre)
                        <a href="{{ route('genre.filter', $genre['id']) }}" class="genre-badge text-decoration-none">
                            {{ $genre['name'] }}
                        </a>
                    @endforeach
                </div>
                @endif

                <!-- Overview -->
                <h5>Sinopsis</h5>
                <p class="lead" style="line-height: 1.8;">
                    {{ $movie['overview'] ?: 'Tidak ada sinopsis tersedia.' }}
                </p>

                <!-- Action Buttons -->
                <div class="mt-4">
                    @auth
                        @if($isFavorited)
                            <form action="{{ route('favorites.destroy', $favoriteFilm->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-lg">
                                    <i class="bi bi-heart-fill"></i> Hapus dari Favorit
                                </button>
                            </form>
                            <a href="{{ route('favorites.edit', $favoriteFilm->id) }}" class="btn btn-outline-primary btn-lg">
                                <i class="bi bi-pencil"></i> Edit Catatan
                            </a>
                        @else
                            <button type="button" class="btn btn-primary btn-lg" data-bs-toggle="modal" data-bs-target="#addFavoriteModal">
                                <i class="bi bi-heart"></i> Tambah ke Favorit
                            </button>
                        @endif
                    @else
                        <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-box-arrow-in-right"></i> Login untuk Menyimpan
                        </a>
                    @endauth

                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <!-- Favorite Info (if favorited) -->
                @if($isFavorited && $favoriteFilm)
                <div class="card mt-4" style="background-color: rgba(255, 193, 7, 0.1); border: 1px solid var(--primary-color);">
                    <div class="card-body">
                        <h6 class="card-title text-primary"><i class="bi bi-heart-fill"></i> Info Favorit Anda</h6>
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-1"><strong>Status:</strong>
                                    <span class="badge bg-primary">{{ \App\Models\FavoriteFilm::getWatchStatuses()[$favoriteFilm->watch_status] }}</span>
                                </p>
                                @if($favoriteFilm->rating)
                                <p class="mb-1"><strong>Rating Anda:</strong>
                                    @for($i = 1; $i <= 10; $i++)
                                        <i class="bi bi-star{{ $i <= $favoriteFilm->rating ? '-fill text-warning' : '' }}"></i>
                                    @endfor
                                </p>
                                @endif
                            </div>
                            <div class="col-md-6">
                                @if($favoriteFilm->personal_note)
                                <p class="mb-1"><strong>Catatan:</strong></p>
                                <p class="text-muted small">{{ $favoriteFilm->personal_note }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Cast Section -->
        @if(isset($movie['credits']['cast']) && count($movie['credits']['cast']) > 0)
        <div class="mt-5">
            <h4 class="mb-4"><i class="bi bi-people"></i> Pemeran</h4>
            <div class="row">
                @foreach(array_slice($movie['credits']['cast'], 0, 6) as $cast)
                <div class="col-6 col-md-4 col-lg-2 mb-3">
                    <div class="card h-100 text-center">
                        @if($cast['profile_path'])
                            <img src="https://image.tmdb.org/t/p/w200{{ $cast['profile_path'] }}" class="card-img-top" alt="{{ $cast['name'] }}" style="height: 200px; object-fit: cover;">
                        @else
                            <div class="card-img-top d-flex align-items-center justify-content-center" style="height: 200px; background: #2a2a2a;">
                                <i class="bi bi-person" style="font-size: 3rem; color: #666;"></i>
                            </div>
                        @endif
                        <div class="card-body py-2">
                            <p class="card-title mb-0 small fw-bold">{{ $cast['name'] }}</p>
                            <p class="card-text text-muted small">{{ $cast['character'] }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Videos Section -->
        @if(isset($movie['videos']['results']) && count($movie['videos']['results']) > 0)
        @php
            $trailer = collect($movie['videos']['results'])->firstWhere('type', 'Trailer');
        @endphp
        @if($trailer)
        <div class="mt-5">
            <h4 class="mb-4"><i class="bi bi-play-circle"></i> Trailer</h4>
            <div class="ratio ratio-16x9" style="max-width: 800px;">
                <iframe src="https://www.youtube.com/embed/{{ $trailer['key'] }}" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>
        </div>
        @endif
        @endif
    </div>
</div>

<!-- Add to Favorite Modal -->
@auth
@if(!$isFavorited)
<div class="modal fade" id="addFavoriteModal" tabindex="-1" aria-labelledby="addFavoriteModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content" style="background-color: var(--card-bg);">
            <div class="modal-header border-secondary">
                <h5 class="modal-title" id="addFavoriteModalLabel">
                    <i class="bi bi-heart"></i> Tambah ke Favorit
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('favorites.store') }}" method="POST">
                @csrf
                <input type="hidden" name="tmdb_id" value="{{ $movie['id'] }}">

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="watch_status" class="form-label">Status Menonton</label>
                        <select class="form-select" id="watch_status" name="watch_status">
                            <option value="want_to_watch">Ingin Ditonton</option>
                            <option value="watching">Sedang Ditonton</option>
                            <option value="watched">Sudah Ditonton</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="personal_note" class="form-label">Catatan Pribadi (Opsional)</label>
                        <textarea class="form-control" id="personal_note" name="personal_note" rows="3" placeholder="Tulis catatan Anda tentang film ini..."></textarea>
                    </div>
                </div>

                <div class="modal-footer border-secondary">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-heart-fill"></i> Simpan ke Favorit
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
@endauth
@endsection
