<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Charges\Resources\ChargeCollection;

class ChargeToggleStatusController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Toggle the active status of an charge.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the charge by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the charge. It returns a JSON response
     * indicating whether the charge was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $charge = $this->chargeService->getById($id);
        try {
            //code...
            $updated_charge = $this->chargeService->toggleActive($charge);
            if ($updated_charge->is_active) {
                return response()->json(["message" => "Charge is now active.", "data" => ChargeCollection::make($updated_charge)], 200);
            }
            return response()->json(["message" => "Charge is now inactive.", "data" => ChargeCollection::make($updated_charge)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
