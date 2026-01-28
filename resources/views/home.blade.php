@extends('layouts.app')

@section('title', $categoryTitle)

@section('content')
<!-- Hero Section -->
<section class="hero-section">
    <div class="container text-center">
        <h1 class="display-4 fw-bold mb-3">Selamat Datang di Portal Film</h1>
        <p class="lead mb-4">Temukan film favorit Anda dan simpan ke koleksi pribadi</p>

        <div class="search-box">
            <form action="{{ route('search') }}" method="GET">
                <div class="input-group input-group-lg">
                    <input type="text" class="form-control" name="q" placeholder="Cari judul film..." value="{{ request('q') }}">
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i> Cari
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>

<div class="container">
    <!-- Category Navigation -->
    <div class="category-nav">
        <ul class="nav nav-pills justify-content-center flex-wrap">
            <li class="nav-item">
                <a class="nav-link {{ $category == 'popular' ? 'active' : '' }}" href="{{ route('home', ['category' => 'popular']) }}">
                    <i class="bi bi-fire"></i> Film Populer
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $category == 'now_playing' ? 'active' : '' }}" href="{{ route('home', ['category' => 'now_playing']) }}">
                    <i class="bi bi-play-circle"></i> Sedang Tayang
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $category == 'top_rated' ? 'active' : '' }}" href="{{ route('home', ['category' => 'top_rated']) }}">
                    <i class="bi bi-star"></i> Rating Tertinggi
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ $category == 'upcoming' ? 'active' : '' }}" href="{{ route('home', ['category' => 'upcoming']) }}">
                    <i class="bi bi-calendar-event"></i> Akan Datang
                </a>
            </li>
        </ul>
    </div>

    <!-- Movies Section -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-film"></i> {{ $categoryTitle }}</h2>
        <span class="text-muted">Total: {{ number_format($totalResults) }} film</span>
    </div>

    @if(count($movies) > 0)
        <div class="row">
            @foreach($movies as $movie)
                @include('components.movie-card', ['movie' => $movie])
            @endforeach
        </div>

        <!-- Pagination -->
        @if($totalPages > 1)
        <nav aria-label="Page navigation" class="mt-5">
            <ul class="pagination justify-content-center">
                @if($currentPage > 1)
                <li class="page-item">
                    <a class="page-link" href="{{ route('home', ['category' => $category, 'page' => $currentPage - 1]) }}">
                        <i class="bi bi-chevron-left"></i> Sebelumnya
                    </a>
                </li>
                @endif

                @php
                    $start = max(1, $currentPage - 2);
                    $end = min($totalPages, $currentPage + 2);
                @endphp

                @for($i = $start; $i <= $end; $i++)
                <li class="page-item {{ $i == $currentPage ? 'active' : '' }}">
                    <a class="page-link" href="{{ route('home', ['category' => $category, 'page' => $i]) }}">{{ $i }}</a>
                </li>
                @endfor

                @if($currentPage < $totalPages)
                <li class="page-item">
                    <a class="page-link" href="{{ route('home', ['category' => $category, 'page' => $currentPage + 1]) }}">
                        Selanjutnya <i class="bi bi-chevron-right"></i>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        @endif
    @else
        <div class="text-center py-5">
            <i class="bi bi-film" style="font-size: 4rem; color: var(--text-muted);"></i>
            <h4 class="mt-3">Tidak ada film ditemukan</h4>
            <p class="text-muted">Coba kategori lain atau gunakan fitur pencarian</p>
        </div>
    @endif
</div>
@endsection
