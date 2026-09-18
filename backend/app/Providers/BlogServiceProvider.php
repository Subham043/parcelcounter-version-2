<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\Blogs\Interfaces\BlogRepositoryInterface;
use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Features\Blogs\Repositories\BlogRepository;
use App\Features\Blogs\Services\BlogService;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            BlogRepositoryInterface::class,
            BlogRepository::class
        );
        $this->app->bind(
            BlogServiceInterface::class,
            BlogService::class
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
