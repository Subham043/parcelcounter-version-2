<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ProductVideos\Interfaces\ProductVideoRepositoryInterface;
use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Features\ProductVideos\Repositories\ProductVideoRepository;
use App\Features\ProductVideos\Services\ProductVideoService;

class ProductVideoServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductVideoRepositoryInterface::class,
            ProductVideoRepository::class
        );
        $this->app->bind(
            ProductVideoServiceInterface::class,
            ProductVideoService::class
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
