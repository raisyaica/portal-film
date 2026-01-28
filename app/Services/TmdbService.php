<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class TmdbService
{
    protected $apiKey;
    protected $baseUrl;
    protected $imageBaseUrl;

    public function __construct()
    {
        $this->apiKey = config('tmdb.api_key');
        $this->baseUrl = config('tmdb.base_url');
        $this->imageBaseUrl = config('tmdb.image_base_url');
    }

    /**
     * Get popular movies
     */
    public function getPopularMovies($page = 1)
    {
        $cacheKey = "popular_movies_page_{$page}";

        return Cache::remember($cacheKey, 3600, function () use ($page) {
            $response = Http::get("{$this->baseUrl}/movie/popular", [
                'api_key' => $this->apiKey,
                'language' => 'id-ID',
                'page' => $page,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    /**
     * Get now playing movies
     */
    public function getNowPlayingMovies($page = 1)
    {
        $cacheKey = "now_playing_movies_page_{$page}";

        return Cache::remember($cacheKey, 3600, function () use ($page) {
            $response = Http::get("{$this->baseUrl}/movie/now_playing", [
                'api_key' => $this->apiKey,
                'language' => 'id-ID',
                'page' => $page,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    /**
     * Get top rated movies
     */
    public function getTopRatedMovies($page = 1)
    {
        $cacheKey = "top_rated_movies_page_{$page}";

        return Cache::remember($cacheKey, 3600, function () use ($page) {
            $response = Http::get("{$this->baseUrl}/movie/top_rated", [
                'api_key' => $this->apiKey,
                'language' => 'id-ID',
                'page' => $page,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    /**
     * Get upcoming movies
     */
    public function getUpcomingMovies($page = 1)
    {
        $cacheKey = "upcoming_movies_page_{$page}";

        return Cache::remember($cacheKey, 3600, function () use ($page) {
            $response = Http::get("{$this->baseUrl}/movie/upcoming", [
                'api_key' => $this->apiKey,
                'language' => 'id-ID',
                'page' => $page,
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    /**
     * Search movies
     */
    public function searchMovies($query, $page = 1)
    {
        $response = Http::get("{$this->baseUrl}/search/movie", [
            'api_key' => $this->apiKey,
            'language' => 'id-ID',
            'query' => $query,
            'page' => $page,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null;
    }

    /**
     * Get movie details
     */
    public function getMovieDetails($movieId)
    {
        $cacheKey = "movie_details_{$movieId}";

        return Cache::remember($cacheKey, 3600, function () use ($movieId) {
            $response = Http::get("{$this->baseUrl}/movie/{$movieId}", [
                'api_key' => $this->apiKey,
                'language' => 'id-ID',
                'append_to_response' => 'credits,videos',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    /**
     * Get movie genres
     */
    public function getGenres()
    {
        $cacheKey = "movie_genres";

        return Cache::remember($cacheKey, 86400, function () {
            $response = Http::get("{$this->baseUrl}/genre/movie/list", [
                'api_key' => $this->apiKey,
                'language' => 'id-ID',
            ]);

            if ($response->successful()) {
                return $response->json()['genres'] ?? [];
            }

            return [];
        });
    }

    /**
     * Discover movies by genre
     */
    public function discoverMoviesByGenre($genreId, $page = 1)
    {
        $cacheKey = "movies_genre_{$genreId}_page_{$page}";

        return Cache::remember($cacheKey, 3600, function () use ($genreId, $page) {
            $response = Http::get("{$this->baseUrl}/discover/movie", [
                'api_key' => $this->apiKey,
                'language' => 'id-ID',
                'with_genres' => $genreId,
                'page' => $page,
                'sort_by' => 'popularity.desc',
            ]);

            if ($response->successful()) {
                return $response->json();
            }

            return null;
        });
    }

    /**
     * Get image URL
     */
    public function getImageUrl($path, $size = 'w500')
    {
        if (empty($path)) {
            return null;
        }
        return "{$this->imageBaseUrl}/{$size}{$path}";
    }
}
