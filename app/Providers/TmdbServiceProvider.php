<?php

namespace App\Providers;

use App\Services\TmdbService;
use Illuminate\Support\ServiceProvider;

class TmdbServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(TmdbService::class, function ($app) {
            return new TmdbService();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
