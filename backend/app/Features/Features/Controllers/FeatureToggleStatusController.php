<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Features\Resources\FeatureCollection;

class FeatureToggleStatusController extends Controller
{
    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Toggle the active status of an feature.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the feature by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the feature. It returns a JSON response
     * indicating whether the feature was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $feature = $this->featureService->getById($id);
        try {
            //code...
            $updated_feature = $this->featureService->toggleActive($feature);
            if ($updated_feature->is_active) {
                return response()->json(["message" => "Feature is now active.", "data" => FeatureCollection::make($updated_feature)], 200);
            }
            return response()->json(["message" => "Feature is now inactive.", "data" => FeatureCollection::make($updated_feature)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
