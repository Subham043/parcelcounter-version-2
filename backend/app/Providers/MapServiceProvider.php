<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Map\Interfaces\MapServiceInterface;
use App\Features\Map\Services\OlaMapService;

class MapServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            MapServiceInterface::class,
            OlaMapService::class
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
