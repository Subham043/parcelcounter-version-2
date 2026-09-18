<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Banners\Interfaces\BannerRepositoryInterface;
use App\Features\Banners\Interfaces\BannerServiceInterface;
use App\Features\Banners\Repositories\BannerRepository;
use App\Features\Banners\Services\BannerService;

class BannerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BannerRepositoryInterface::class,
            BannerRepository::class
        );
        $this->app->bind(
            BannerServiceInterface::class,
            BannerService::class
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
