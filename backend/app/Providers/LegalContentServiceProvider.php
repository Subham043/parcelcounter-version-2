<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\LegalContents\Interfaces\LegalContentRepositoryInterface;
use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Features\LegalContents\Repositories\LegalContentRepository;
use App\Features\LegalContents\Services\LegalContentService;

class LegalContentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            LegalContentRepositoryInterface::class,
            LegalContentRepository::class
        );
        $this->app->bind(
            LegalContentServiceInterface::class,
            LegalContentService::class
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
