<?php

namespace App\Http\Controllers;

use App\Services\TmdbService;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
    }

    /**
     * Show film details
     */
    public function show($id)
    {
        $movie = $this->tmdbService->getMovieDetails($id);

        if (!$movie) {
            abort(404, 'Film tidak ditemukan.');
        }

        $genres = $this->tmdbService->getGenres();

        // Check if user has favorited this movie
        $isFavorited = false;
        $favoriteFilm = null;

        if (auth()->check()) {
            $favoriteFilm = auth()->user()->favoriteFilms()
                ->where('tmdb_id', $id)
                ->first();
            $isFavorited = $favoriteFilm !== null;
        }

        return view('films.show', [
            'movie' => $movie,
            'genres' => $genres,
            'isFavorited' => $isFavorited,
            'favoriteFilm' => $favoriteFilm,
        ]);
    }
}
