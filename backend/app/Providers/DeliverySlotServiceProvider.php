<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Features\DeliverySlots\Interfaces\DeliverySlotRepositoryInterface;
use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Features\DeliverySlots\Repositories\DeliverySlotRepository;
use App\Features\DeliverySlots\Services\DeliverySlotService;

class DeliverySlotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            DeliverySlotRepositoryInterface::class,
            DeliverySlotRepository::class
        );
        $this->app->bind(
            DeliverySlotServiceInterface::class,
            DeliverySlotService::class
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
