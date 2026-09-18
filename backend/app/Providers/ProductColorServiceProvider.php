<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ProductColors\Interfaces\ProductColorRepositoryInterface;
use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Features\ProductColors\Repositories\ProductColorRepository;
use App\Features\ProductColors\Services\ProductColorService;

class ProductColorServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductColorRepositoryInterface::class,
            ProductColorRepository::class
        );
        $this->app->bind(
            ProductColorServiceInterface::class,
            ProductColorService::class
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
