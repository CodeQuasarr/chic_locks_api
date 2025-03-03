<?php

namespace App\Providers;


use Illuminate\Support\Facades\Gate;
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
        Gate::policy(\App\Models\User::class, \App\Policies\User\UserPolicy::class);

        $this->app->bind(
            \App\Interfaces\Auth\LoginServiceInterface::class,
            \App\Services\Auth\LoginService::class
        );

        $this->app->bind(
            \App\Interfaces\Auth\TokenServiceInterface::class,
            \App\Services\Auth\TokenService::class
        );

        $this->app->bind(
            \App\Interfaces\Auth\RegisterServiceInterface::class,
            \App\Services\Auth\RegisterService::class
        );

        $this->app->bind(
            \App\Interfaces\User\UserServiceInterface::class,
            \App\Services\User\UserService::class
        );
    }
}
