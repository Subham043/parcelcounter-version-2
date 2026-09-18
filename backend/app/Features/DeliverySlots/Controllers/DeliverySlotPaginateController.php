<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Resources\DeliverySlotCollection;
use Illuminate\Http\Request;

class DeliverySlotPaginateController extends Controller
{
    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Returns a paginated collection of slots.
     *
     * @param Request $request
     * @return DeliverySlotCollection
     */
    public function index(Request $request)
    {
        $data = $this->slotService->paginate($request->total ?? 10);
        return DeliverySlotCollection::collection($data);
    }
}
