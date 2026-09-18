<?php

namespace App\Providers;

use App\Http\Interfaces\FileStorageServiceInterface;
use App\Http\Services\FileStorageService;
use Illuminate\Support\ServiceProvider;

class FileStorageServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            FileStorageServiceInterface::class,
            FileStorageService::class
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
