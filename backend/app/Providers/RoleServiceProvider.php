<?php

namespace App\Providers;

use App\Features\Roles\Interfaces\RoleRepositoryInterface;
use App\Features\Roles\Interfaces\RoleServiceInterface;
use App\Features\Roles\Repositories\RoleRepository;
use App\Features\Roles\Services\RoleService;
use Illuminate\Support\ServiceProvider;

class RoleServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            RoleRepositoryInterface::class,
            RoleRepository::class
        );
        $this->app->bind(
            RoleServiceInterface::class,
            RoleService::class
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
