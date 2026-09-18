<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ProductImages\Interfaces\ProductImageRepositoryInterface;
use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Features\ProductImages\Repositories\ProductImageRepository;
use App\Features\ProductImages\Services\ProductImageService;

class ProductImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductImageRepositoryInterface::class,
            ProductImageRepository::class
        );
        $this->app->bind(
            ProductImageServiceInterface::class,
            ProductImageService::class
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
