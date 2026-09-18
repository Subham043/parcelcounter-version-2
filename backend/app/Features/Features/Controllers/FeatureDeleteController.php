<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Features\Resources\FeatureCollection;

class FeatureDeleteController extends Controller
{
    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Delete a feature
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $feature = $this->featureService->getById($id);
        try {
            //code...
            $this->featureService->delete($feature);
            return response()->json(["message" => "Feature deleted successfully.", "data" => FeatureCollection::make($feature)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
