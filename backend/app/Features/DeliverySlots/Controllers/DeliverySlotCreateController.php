<?php

namespace App\Features\DeliverySlots\Controllers;

use App\Features\DeliverySlots\DTO\DeliverySlotDTO;
use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\DeliverySlots\Requests\DeliverySlotPostRequest;
use App\Features\DeliverySlots\Resources\DeliverySlotCollection;

class DeliverySlotCreateController extends Controller
{

    public function __construct(private DeliverySlotServiceInterface $slotService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(DeliverySlotPostRequest $request)
    {
        try {
            //code...
            $slot = $this->slotService->create(
                DeliverySlotDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Delivery Slot created successfully.",
                "data" => DeliverySlotCollection::make($slot),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
