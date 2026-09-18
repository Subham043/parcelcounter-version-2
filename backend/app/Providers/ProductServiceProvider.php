<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Products\Interfaces\ProductRepositoryInterface;
use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Features\Products\Repositories\ProductRepository;
use App\Features\Products\Services\ProductService;

class ProductServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductRepositoryInterface::class,
            ProductRepository::class
        );
        $this->app->bind(
            ProductServiceInterface::class,
            ProductService::class
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
