<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AuthApiService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthApiService::class, function ($app) {
            return new AuthApiService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
