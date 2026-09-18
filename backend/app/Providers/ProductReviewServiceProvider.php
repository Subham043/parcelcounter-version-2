<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\ProductReviews\Interfaces\ProductReviewRepositoryInterface;
use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Features\ProductReviews\Repositories\ProductReviewRepository;
use App\Features\ProductReviews\Services\ProductReviewService;

class ProductReviewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            ProductReviewRepositoryInterface::class,
            ProductReviewRepository::class
        );
        $this->app->bind(
            ProductReviewServiceInterface::class,
            ProductReviewService::class
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
