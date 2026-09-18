<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Features\Resources\FeatureCollection;

class FeatureViewController extends Controller
{
    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $feature = $this->featureService->getById($id);
        return response()->json(["message" => "Feature fetched successfully.", "data" => FeatureCollection::make($feature)], 200);
    }
}
