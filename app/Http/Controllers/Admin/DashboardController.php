<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FavoriteFilm;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Show admin dashboard
     */
    public function index()
    {
        $totalUsers = User::where('role', User::ROLE_USER)->count();
        $totalAdmins = User::where('role', User::ROLE_ADMIN)->count();
        $totalFavorites = FavoriteFilm::count();

        $recentUsers = User::where('role', User::ROLE_USER)
            ->latest()
            ->take(5)
            ->get();

        $popularFavorites = FavoriteFilm::select('tmdb_id', 'title', 'poster_path')
            ->selectRaw('COUNT(*) as total')
            ->groupBy('tmdb_id', 'title', 'poster_path')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        return view('admin.dashboard', [
            'totalUsers' => $totalUsers,
            'totalAdmins' => $totalAdmins,
            'totalFavorites' => $totalFavorites,
            'recentUsers' => $recentUsers,
            'popularFavorites' => $popularFavorites,
        ]);
    }
}
