<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Categories\Interfaces\CategoryRepositoryInterface;
use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Features\Categories\Repositories\CategoryRepository;
use App\Features\Categories\Services\CategoryService;

class CategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
        $this->app->bind(
            CategoryServiceInterface::class,
            CategoryService::class
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
