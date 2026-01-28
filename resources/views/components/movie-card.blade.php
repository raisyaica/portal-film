@props(['movie', 'showFavorite' => true])

@php
    $posterUrl = $movie['poster_path']
        ? 'https://image.tmdb.org/t/p/w500' . $movie['poster_path']
        : null;

    $isFavorited = false;
    if (auth()->check()) {
        $isFavorited = auth()->user()->favoriteFilms()
            ->where('tmdb_id', $movie['id'])
            ->exists();
    }
@endphp

<div class="col-6 col-md-4 col-lg-3 col-xl-2 mb-4">
    <div class="movie-card card h-100 position-relative">
        @auth
            @if($showFavorite)
            <button class="favorite-btn {{ $isFavorited ? 'favorited' : '' }}"
                    onclick="toggleFavorite(this, {{ $movie['id'] }})"
                    title="{{ $isFavorited ? 'Hapus dari favorit' : 'Tambah ke favorit' }}">
                <i class="bi {{ $isFavorited ? 'bi-heart-fill' : 'bi-heart' }}"></i>
            </button>
            @endif
        @endauth

        <a href="{{ route('film.show', $movie['id']) }}" class="text-decoration-none">
            @if($posterUrl)
                <img src="{{ $posterUrl }}" class="card-img-top" alt="{{ $movie['title'] }}" loading="lazy">
            @else
                <div class="no-poster">
                    <i class="bi bi-film" style="font-size: 3rem;"></i>
                </div>
            @endif

            <div class="card-body">
                <h6 class="card-title" title="{{ $movie['title'] }}">{{ $movie['title'] }}</h6>
                <div class="d-flex justify-content-between align-items-center">
                    <span class="rating">
                        <i class="bi bi-star-fill"></i>
                        {{ number_format($movie['vote_average'], 1) }}
                    </span>
                    <span class="release-date">
                        {{ $movie['release_date'] ? \Carbon\Carbon::parse($movie['release_date'])->format('Y') : 'N/A' }}
                    </span>
                </div>
            </div>
        </a>
    </div>
</div>
