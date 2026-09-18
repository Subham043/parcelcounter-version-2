<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Resources\DeliverySlotCollection;

class DeliverySlotToggleStatusController extends Controller
{
    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Toggle the active status of an slot.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the slot by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the slot. It returns a JSON response
     * indicating whether the slot was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $slot = $this->slotService->getById($id);
        try {
            //code...
            $updated_slot = $this->slotService->toggleActive($slot);
            if ($updated_slot->is_active) {
                return response()->json(["message" => "Delivery Slot is now active.", "data" => DeliverySlotCollection::make($updated_slot)], 200);
            }
            return response()->json(["message" => "Delivery Slot is now inactive.", "data" => DeliverySlotCollection::make($updated_slot)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
