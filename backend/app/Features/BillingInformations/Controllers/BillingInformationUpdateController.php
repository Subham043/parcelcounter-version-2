<?php

namespace App\Features\BillingInformations\Controllers;

use App\Features\BillingInformations\DTO\BillingInformationDTO;
use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Requests\BillingInformationPostRequest;
use App\Features\BillingInformations\Resources\BillingInformationCollection;

class BillingInformationUpdateController extends Controller
{
    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Update an information
     *
     * @param BillingInformationPostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(BillingInformationPostRequest $request, $id)
    {
        $information = $this->informationService->getById($id);
        try {
            //code...
            $updated_information = $this->informationService->update(
                BillingInformationDTO::fromRequest($request),
                $information
            );
            return response()->json(["message" => "Billing information updated successfully.", "data" => BillingInformationCollection::make($updated_information)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
