<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\DTO\FeatureDTO;
use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Features\Requests\FeatureCreatePostRequest;
use App\Features\Features\Resources\FeatureCollection;

class FeatureCreateController extends Controller
{

    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(FeatureCreatePostRequest $request)
    {
        try {
            //code...
            $feature = $this->featureService->create(
                FeatureDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Feature created successfully.",
                "data" => FeatureCollection::make($feature),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
