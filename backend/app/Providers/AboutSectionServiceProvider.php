<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\AboutSections\Interfaces\AboutSectionRepositoryInterface;
use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Features\AboutSections\Repositories\AboutSectionRepository;
use App\Features\AboutSections\Services\AboutSectionService;

class AboutSectionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            AboutSectionRepositoryInterface::class,
            AboutSectionRepository::class
        );
        $this->app->bind(
            AboutSectionServiceInterface::class,
            AboutSectionService::class
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
