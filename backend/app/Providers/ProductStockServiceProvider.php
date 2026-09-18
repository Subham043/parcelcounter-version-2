<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ProductStocks\Interfaces\ProductStockRepositoryInterface;
use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Features\ProductStocks\Repositories\ProductStockRepository;
use App\Features\ProductStocks\Services\ProductStockService;

class ProductStockServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductStockRepositoryInterface::class,
            ProductStockRepository::class
        );
        $this->app->bind(
            ProductStockServiceInterface::class,
            ProductStockService::class
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
