<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\DTO\ChargeDTO;
use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Charges\Requests\ChargeCreatePostRequest;
use App\Features\Charges\Resources\ChargeCollection;

class ChargeCreateController extends Controller
{

    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(ChargeCreatePostRequest $request)
    {
        try {
            //code...
            $charge = $this->chargeService->create(
                ChargeDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Charge created successfully.",
                "data" => ChargeCollection::make($charge),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
