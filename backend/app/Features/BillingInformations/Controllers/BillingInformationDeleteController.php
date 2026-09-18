<?php

namespace App\Features\BillingInformations\Controllers;

use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Resources\BillingInformationCollection;

class BillingInformationDeleteController extends Controller
{
    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Delete a information
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $information = $this->informationService->getById($id);
        try {
            //code...
            $this->informationService->delete($information);
            return response()->json(["message" => "Billing information deleted successfully.", "data" => BillingInformationCollection::make($information)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
