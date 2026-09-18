<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\DTO\TaxDTO;
use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Requests\TaxCreatePostRequest;
use App\Features\Taxes\Resources\TaxCollection;

class TaxCreateController extends Controller
{

    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(TaxCreatePostRequest $request)
    {
        try {
            //code...
            $tax = $this->taxService->create(
                TaxDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Tax created successfully.",
                "data" => TaxCollection::make($tax),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
