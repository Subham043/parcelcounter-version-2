<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Charges\Resources\ChargeCollection;

class ChargeDeleteController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Delete a charge
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $charge = $this->chargeService->getById($id);
        try {
            //code...
            $this->chargeService->delete($charge);
            return response()->json(["message" => "Charge deleted successfully.", "data" => ChargeCollection::make($charge)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
