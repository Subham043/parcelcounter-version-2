<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\SubCategories\Interfaces\SubCategoryRepositoryInterface;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Features\SubCategories\Repositories\SubCategoryRepository;
use App\Features\SubCategories\Services\SubCategoryService;

class SubCategoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            SubCategoryRepositoryInterface::class,
            SubCategoryRepository::class
        );
        $this->app->bind(
            SubCategoryServiceInterface::class,
            SubCategoryService::class
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
