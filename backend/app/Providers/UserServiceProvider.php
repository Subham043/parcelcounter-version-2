<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Users\Interfaces\UserRepositoryInterface;
use App\Features\Users\Interfaces\UserServiceInterface;
use App\Features\Users\Repositories\UserRepository;
use App\Features\Users\Services\UserService;

class UserServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            UserServiceInterface::class,
            UserService::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
