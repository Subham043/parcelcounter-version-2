<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationRepositoryInterface;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Features\ProductSpecifications\Repositories\ProductSpecificationRepository;
use App\Features\ProductSpecifications\Services\ProductSpecificationService;

class ProductSpecificationServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductSpecificationRepositoryInterface::class,
            ProductSpecificationRepository::class
        );
        $this->app->bind(
            ProductSpecificationServiceInterface::class,
            ProductSpecificationService::class
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
