<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Resources\DeliverySlotCollection;

class DeliverySlotDeleteController extends Controller
{
    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Delete a slot
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $slot = $this->slotService->getById($id);
        try {
            //code...
            $this->slotService->delete($slot);
            return response()->json(["message" => "Delivery Slot deleted successfully.", "data" => DeliverySlotCollection::make($slot)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
