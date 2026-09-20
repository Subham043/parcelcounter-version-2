<?php

namespace App\Features\Map\Controllers;

use App\Features\Map\Interfaces\MapServiceInterface;
use App\Features\Map\Requests\DirectionPostRequest;
use App\Http\Controllers\Controller;

class MapDirectionController extends Controller
{
    public function __construct(private MapServiceInterface $mapService) {}

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(DirectionPostRequest $request)
    {
        $request->validated();
        $data = $this->mapService->getDirection(
            $request->origin_lat, 
            $request->origin_lng, 
            $request->destination_lat, 
            $request->destination_lng
        );
        return response()->json(['data' => $data], 200);
    }
}
