<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Resources\TaxCollection;

class TaxToggleStatusController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Toggle the active status of an tax.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the tax by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the tax. It returns a JSON response
     * indicating whether the tax was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $tax = $this->taxService->getById($id);
        try {
            //code...
            $updated_tax = $this->taxService->toggleActive($tax);
            if ($updated_tax->is_active) {
                return response()->json(["message" => "Tax is now active.", "data" => TaxCollection::make($updated_tax)], 200);
            }
            return response()->json(["message" => "Tax is now inactive.", "data" => TaxCollection::make($updated_tax)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
