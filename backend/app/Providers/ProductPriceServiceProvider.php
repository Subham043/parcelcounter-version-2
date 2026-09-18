<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ProductPrices\Interfaces\ProductPriceRepositoryInterface;
use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Features\ProductPrices\Repositories\ProductPriceRepository;
use App\Features\ProductPrices\Services\ProductPriceService;

class ProductPriceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductPriceRepositoryInterface::class,
            ProductPriceRepository::class
        );
        $this->app->bind(
            ProductPriceServiceInterface::class,
            ProductPriceService::class
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
