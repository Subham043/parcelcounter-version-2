<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\DTO\FeatureDTO;
use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Features\Requests\FeatureUpdatePostRequest;
use App\Features\Features\Resources\FeatureCollection;

class FeatureUpdateController extends Controller
{
    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Update an feature
     *
     * @param FeatureUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(FeatureUpdatePostRequest $request, $id)
    {
        $feature = $this->featureService->getById($id);
        try {
            //code...
            $updated_feature = $this->featureService->update(
                FeatureDTO::fromRequest($request),
                $feature
            );
            return response()->json(["message" => "Feature updated successfully.", "data" => FeatureCollection::make($updated_feature)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
