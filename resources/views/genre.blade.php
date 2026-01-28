@extends('layouts.app')

@section('title', 'Genre: ' . $genreName)

@section('content')
<div class="container py-4">
    <!-- Genre Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2><i class="bi bi-tag"></i> Genre: {{ $genreName }}</h2>
            <p class="text-muted mb-0">{{ number_format($totalResults) }} film ditemukan</p>
        </div>
        <a href="{{ route('home') }}" class="btn btn-outline-primary">
            <i class="bi bi-arrow-left"></i> Kembali
        </a>
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
                    <a class="page-link" href="{{ route('genre.filter', ['id' => $genreId, 'page' => $currentPage - 1]) }}">
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
                    <a class="page-link" href="{{ route('genre.filter', ['id' => $genreId, 'page' => $i]) }}">{{ $i }}</a>
                </li>
                @endfor

                @if($currentPage < $totalPages)
                <li class="page-item">
                    <a class="page-link" href="{{ route('genre.filter', ['id' => $genreId, 'page' => $currentPage + 1]) }}">
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
            <p class="text-muted">Tidak ditemukan film untuk genre {{ $genreName }}</p>
            <a href="{{ route('home') }}" class="btn btn-primary mt-3">
                <i class="bi bi-house"></i> Kembali ke Beranda
            </a>
        </div>
    @endif
</div>
@endsection
