<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Features\Interfaces\FeatureRepositoryInterface;
use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Features\Features\Repositories\FeatureRepository;
use App\Features\Features\Services\FeatureService;

class FeatureServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            FeatureRepositoryInterface::class,
            FeatureRepository::class
        );
        $this->app->bind(
            FeatureServiceInterface::class,
            FeatureService::class
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
