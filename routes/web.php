<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/genre/{id}', [HomeController::class, 'filterByGenre'])->name('genre.filter');
Route::get('/film/{id}', [FilmController::class, 'show'])->name('film.show');

// Guest routes (only for non-authenticated users)
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
    Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [RegisterController::class, 'register']);
});

// Authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Favorites routes
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites', [FavoriteController::class, 'store'])->name('favorites.store');
    Route::get('/favorites/{id}/edit', [FavoriteController::class, 'edit'])->name('favorites.edit');
    Route::put('/favorites/{id}', [FavoriteController::class, 'update'])->name('favorites.update');
    Route::delete('/favorites/{id}', [FavoriteController::class, 'destroy'])->name('favorites.destroy');

    // Quick add/remove (AJAX)
    Route::post('/favorites/quick-add', [FavoriteController::class, 'quickAdd'])->name('favorites.quickAdd');
    Route::post('/favorites/quick-remove', [FavoriteController::class, 'quickRemove'])->name('favorites.quickRemove');
});

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [AdminUserController::class, 'show'])->name('users.show');
    Route::delete('/users/{id}', [AdminUserController::class, 'destroy'])->name('users.destroy');
});
