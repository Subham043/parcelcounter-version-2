<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\DTO\DeliverySlotFilterDTO;
use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Features\DeliverySlots\Requests\DeliverySlotFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Resources\DeliverySlotCollection;

class DeliverySlotPaginateController extends Controller
{
    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Returns a paginated collection of slots.
     *
     * @param DeliverySlotFilterRequest $request
     * @return DeliverySlotCollection
     */
    public function index(DeliverySlotFilterRequest $request)
    {
        $data = $this->slotService->paginate(DeliverySlotFilterDTO::fromRequest($request));
        return DeliverySlotCollection::collection($data);
    }
}
