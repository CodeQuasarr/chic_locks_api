<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        $this->app->bind(
            \App\Interfaces\Auth\LoginServiceInterface::class,
            \App\Services\Auth\LoginService::class
        );

        $this->app->bind(
            \App\Interfaces\Auth\TokenServiceInterface::class,
            \App\Services\Auth\TokenService::class
        );
    }
}
