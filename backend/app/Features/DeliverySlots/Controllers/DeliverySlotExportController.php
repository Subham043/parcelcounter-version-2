<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\DTO\DeliverySlotFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Features\DeliverySlots\Requests\DeliverySlotFilterRequest;

class DeliverySlotExportController extends Controller
{
    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Download all slots as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(DeliverySlotFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->slotService->exportDeliverySlots(DeliverySlotFilterDTO::fromRequest($request));
    }
}
