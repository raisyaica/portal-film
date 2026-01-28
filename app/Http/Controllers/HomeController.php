<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    /**
     * Show home page with popular movies
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 1);
        $category = $request->get('category', 'popular');

        switch ($category) {
            case 'now_playing':
                $movies = $this->tmdbService->getNowPlayingMovies($page);
                $categoryTitle = 'Sedang Tayang';
                break;
            case 'top_rated':
                $movies = $this->tmdbService->getTopRatedMovies($page);
                $categoryTitle = 'Rating Tertinggi';
                break;
            case 'upcoming':
                $movies = $this->tmdbService->getUpcomingMovies($page);
                $categoryTitle = 'Akan Datang';
                break;
            default:
                $movies = $this->tmdbService->getPopularMovies($page);
                $categoryTitle = 'Film Populer';
                break;
        }

        $genres = $this->tmdbService->getGenres();

        return view('home', [
            'movies' => $movies['results'] ?? [],
            'currentPage' => $movies['page'] ?? 1,
            'totalPages' => $movies['total_pages'] ?? 1,
            'totalResults' => $movies['total_results'] ?? 0,
            'category' => $category,
            'categoryTitle' => $categoryTitle,
            'genres' => $genres,
        ]);
    }

    /**
     * Search movies
     */
    public function search(Request $request)
    {
        $query = $request->get('q', '');
        $page = $request->get('page', 1);

        if (empty($query)) {
            return redirect()->route('home');
        }

        $movies = $this->tmdbService->searchMovies($query, $page);
        $genres = $this->tmdbService->getGenres();

        return view('search', [
            'movies' => $movies['results'] ?? [],
            'currentPage' => $movies['page'] ?? 1,
            'totalPages' => $movies['total_pages'] ?? 1,
            'totalResults' => $movies['total_results'] ?? 0,
            'query' => $query,
            'genres' => $genres,
        ]);
    }

    /**
     * Filter movies by genre
     */
    public function filterByGenre(Request $request, $genreId)
    {
        $page = $request->get('page', 1);

        $movies = $this->tmdbService->discoverMoviesByGenre($genreId, $page);
        $genres = $this->tmdbService->getGenres();

        // Find genre name
        $genreName = 'Unknown';
        foreach ($genres as $genre) {
            if ($genre['id'] == $genreId) {
                $genreName = $genre['name'];
                break;
            }
        }

        return view('genre', [
            'movies' => $movies['results'] ?? [],
            'currentPage' => $movies['page'] ?? 1,
            'totalPages' => $movies['total_pages'] ?? 1,
            'totalResults' => $movies['total_results'] ?? 0,
            'genreId' => $genreId,
            'genreName' => $genreName,
            'genres' => $genres,
        ]);
    }
}
