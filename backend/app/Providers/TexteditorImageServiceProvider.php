<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\TexteditorImages\Interfaces\TexteditorImageRepositoryInterface;
use App\Features\TexteditorImages\Interfaces\TexteditorImageServiceInterface;
use App\Features\TexteditorImages\Repositories\TexteditorImageRepository;
use App\Features\TexteditorImages\Services\TexteditorImageService;

class TexteditorImageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            TexteditorImageRepositoryInterface::class,
            TexteditorImageRepository::class
        );
        $this->app->bind(
            TexteditorImageServiceInterface::class,
            TexteditorImageService::class
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
