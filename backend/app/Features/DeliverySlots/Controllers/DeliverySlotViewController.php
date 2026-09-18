<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Resources\DeliverySlotCollection;

class DeliverySlotViewController extends Controller
{
    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $slot = $this->slotService->getById($id);
        return response()->json(["message" => "Delivery Slot fetched successfully.", "data" => DeliverySlotCollection::make($slot)], 200);
    }
}
