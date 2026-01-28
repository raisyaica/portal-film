<?php

namespace App\Http\Controllers;

use App\Models\FavoriteFilm;
use App\Services\TmdbService;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    protected $tmdbService;

    public function __construct(TmdbService $tmdbService)
    {
        $this->tmdbService = $tmdbService;
        $this->middleware('auth');
    }

    /**
     * Display user's favorite films
     */
    public function index(Request $request)
    {
        $status = $request->get('status', '');
        $query = auth()->user()->favoriteFilms()->latest();

        if (!empty($status)) {
            $query->byStatus($status);
        }

        $favorites = $query->paginate(12);
        $statuses = FavoriteFilm::getWatchStatuses();

        return view('favorites.index', [
            'favorites' => $favorites,
            'statuses' => $statuses,
            'currentStatus' => $status,
        ]);
    }

    /**
     * Add film to favorites
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tmdb_id' => 'required|integer',
            'personal_note' => 'nullable|string|max:1000',
            'watch_status' => 'nullable|in:want_to_watch,watching,watched',
        ]);

        // Check if already exists
        $existing = auth()->user()->favoriteFilms()
            ->where('tmdb_id', $validated['tmdb_id'])
            ->first();

        if ($existing) {
            return back()->with('error', 'Film sudah ada di koleksi favorit Anda.');
        }

        // Get movie details from TMDb
        $movie = $this->tmdbService->getMovieDetails($validated['tmdb_id']);

        if (!$movie) {
            return back()->with('error', 'Film tidak ditemukan.');
        }

        // Create favorite film
        auth()->user()->favoriteFilms()->create([
            'tmdb_id' => $movie['id'],
            'title' => $movie['title'],
            'original_title' => $movie['original_title'] ?? null,
            'overview' => $movie['overview'] ?? null,
            'poster_path' => $movie['poster_path'] ?? null,
            'backdrop_path' => $movie['backdrop_path'] ?? null,
            'release_date' => $movie['release_date'] ?? null,
            'vote_average' => $movie['vote_average'] ?? 0,
            'vote_count' => $movie['vote_count'] ?? 0,
            'popularity' => $movie['popularity'] ?? 0,
            'genre_ids' => array_column($movie['genres'] ?? [], 'id'),
            'personal_note' => $validated['personal_note'] ?? null,
            'watch_status' => $validated['watch_status'] ?? 'want_to_watch',
        ]);

        return back()->with('success', 'Film berhasil ditambahkan ke koleksi favorit!');
    }

    /**
     * Show edit form for favorite film
     */
    public function edit($id)
    {
        $favorite = auth()->user()->favoriteFilms()->findOrFail($id);
        $statuses = FavoriteFilm::getWatchStatuses();

        return view('favorites.edit', [
            'favorite' => $favorite,
            'statuses' => $statuses,
        ]);
    }

    /**
     * Update favorite film
     */
    public function update(Request $request, $id)
    {
        $favorite = auth()->user()->favoriteFilms()->findOrFail($id);

        $validated = $request->validate([
            'personal_note' => 'nullable|string|max:1000',
            'watch_status' => 'required|in:want_to_watch,watching,watched',
            'rating' => 'nullable|integer|min:1|max:10',
        ]);

        $favorite->update($validated);

        return redirect()->route('favorites.index')
            ->with('success', 'Film favorit berhasil diperbarui!');
    }

    /**
     * Remove film from favorites
     */
    public function destroy($id)
    {
        $favorite = auth()->user()->favoriteFilms()->findOrFail($id);
        $favorite->delete();

        return back()->with('success', 'Film berhasil dihapus dari koleksi favorit.');
    }

    /**
     * Quick add to favorites (AJAX)
     */
    public function quickAdd(Request $request)
    {
        $validated = $request->validate([
            'tmdb_id' => 'required|integer',
        ]);

        // Check if already exists
        $existing = auth()->user()->favoriteFilms()
            ->where('tmdb_id', $validated['tmdb_id'])
            ->first();

        if ($existing) {
            return response()->json([
                'success' => false,
                'message' => 'Film sudah ada di koleksi favorit Anda.',
            ]);
        }

        // Get movie details from TMDb
        $movie = $this->tmdbService->getMovieDetails($validated['tmdb_id']);

        if (!$movie) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan.',
            ]);
        }

        // Create favorite film
        auth()->user()->favoriteFilms()->create([
            'tmdb_id' => $movie['id'],
            'title' => $movie['title'],
            'original_title' => $movie['original_title'] ?? null,
            'overview' => $movie['overview'] ?? null,
            'poster_path' => $movie['poster_path'] ?? null,
            'backdrop_path' => $movie['backdrop_path'] ?? null,
            'release_date' => $movie['release_date'] ?? null,
            'vote_average' => $movie['vote_average'] ?? 0,
            'vote_count' => $movie['vote_count'] ?? 0,
            'popularity' => $movie['popularity'] ?? 0,
            'genre_ids' => array_column($movie['genres'] ?? [], 'id'),
            'watch_status' => 'want_to_watch',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil ditambahkan ke favorit!',
        ]);
    }

    /**
     * Quick remove from favorites (AJAX)
     */
    public function quickRemove(Request $request)
    {
        $validated = $request->validate([
            'tmdb_id' => 'required|integer',
        ]);

        $favorite = auth()->user()->favoriteFilms()
            ->where('tmdb_id', $validated['tmdb_id'])
            ->first();

        if (!$favorite) {
            return response()->json([
                'success' => false,
                'message' => 'Film tidak ditemukan di koleksi favorit.',
            ]);
        }

        $favorite->delete();

        return response()->json([
            'success' => true,
            'message' => 'Film berhasil dihapus dari favorit!',
        ]);
    }
}
