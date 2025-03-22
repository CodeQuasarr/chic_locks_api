<?php

namespace App\Providers;


use App\Models\User;
use App\Models\Users\UserAddress;
use App\Policies\Users\UserAddressPolicy;
use App\Policies\Users\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Les mappings entre les modèles et les Policies.
     *
     * @var array
     */
    protected $policies = [
        User::class => UserPolicy::class,
        UserAddress::class => UserAddressPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Bindings d'interface
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
            \App\Interfaces\Users\UserServiceInterface::class,
            \App\Services\Users\UserService::class
        );

        $this->app->bind(
            \App\Interfaces\Users\UserAddressServiceInterface::class,
            \App\Services\Users\UserAddressService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Enregistre les Policies
        foreach ($this->policies as $model => $policy) {
            Gate::policy($model, $policy);
        }
    }
}
