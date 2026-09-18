<?php

namespace App\Features\BillingInformations\Controllers;

use App\Features\BillingInformations\DTO\BillingInformationDTO;
use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Requests\BillingInformationPostRequest;
use App\Features\BillingInformations\Resources\BillingInformationCollection;

class BillingInformationCreateController extends Controller
{

    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(BillingInformationPostRequest $request)
    {
        try {
            //code...
            $information = $this->informationService->create(
                BillingInformationDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Billing information created successfully.",
                "data" => BillingInformationCollection::make($information),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
