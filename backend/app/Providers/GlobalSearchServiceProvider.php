<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\GlobalSearch\Interfaces\GlobalSearchRepositoryInterface;
use App\Features\GlobalSearch\Interfaces\GlobalSearchServiceInterface;
use App\Features\GlobalSearch\Repositories\GlobalSearchRepository;
use App\Features\GlobalSearch\Services\GlobalSearchService;

class GlobalSearchServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            GlobalSearchRepositoryInterface::class,
            GlobalSearchRepository::class
        );
        $this->app->bind(
            GlobalSearchServiceInterface::class,
            GlobalSearchService::class
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
