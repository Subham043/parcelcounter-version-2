<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\DTO\ChargeDTO;
use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Charges\Requests\ChargeUpdatePostRequest;
use App\Features\Charges\Resources\ChargeCollection;

class ChargeUpdateController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Update an charge
     *
     * @param ChargeUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ChargeUpdatePostRequest $request, $id)
    {
        $charge = $this->chargeService->getById($id);
        try {
            //code...
            $updated_charge = $this->chargeService->update(
                ChargeDTO::fromRequest($request),
                $charge
            );
            return response()->json(["message" => "Charge updated successfully.", "data" => ChargeCollection::make($updated_charge)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
