<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\DTO\DeliverySlotDTO;
use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Requests\DeliverySlotPostRequest;
use App\Features\DeliverySlots\Resources\DeliverySlotCollection;

class DeliverySlotUpdateController extends Controller
{
    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Update an slot
     *
     * @param DeliverySlotPostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(DeliverySlotPostRequest $request, $id)
    {
        $slot = $this->slotService->getById($id);
        try {
            //code...
            $updated_slot = $this->slotService->update(
                DeliverySlotDTO::fromRequest($request),
                $slot
            );
            return response()->json(["message" => "Delivery Slot updated successfully.", "data" => DeliverySlotCollection::make($updated_slot)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
