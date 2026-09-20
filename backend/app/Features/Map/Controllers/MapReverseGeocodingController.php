<?php

namespace App\Features\Map\Controllers;

use App\Features\Map\DTO\ReverseGeocodingRequestDTO;
use App\Features\Map\DTO\ReverseGeocodingResponseDTO;
use App\Features\Map\Interfaces\MapServiceInterface;
use App\Features\Map\Requests\ReverseGeocodingPostRequest;
use App\Features\Map\Resources\ReverseGeocodingCollection;
use App\Http\Controllers\Controller;

class MapReverseGeocodingController extends Controller
{
    public function __construct(private MapServiceInterface $mapService) {}

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(ReverseGeocodingPostRequest $request)
    {
        $data = $this->mapService->getReverseGeocoding(ReverseGeocodingRequestDTO::fromRequest($request));
        $latitude = (float) $request->lat;
        $longitude = (float) $request->lng;

        $result = collect($data)
            ->first(function (array $item) use ($latitude, $longitude) {
                return (float) data_get($item, 'geometry.location.lat') === $latitude
                    && (float) data_get($item, 'geometry.location.lng') === $longitude;
            });

        if (!$result) {
            return response()->json([
                'message' => 'Location not found.',
            ], 404);
        }

        $dto = ReverseGeocodingResponseDTO::fromOla($result);

        return response()->json([
            'message' => 'Reverse geocoding fetched successfully.',
            'data' => ReverseGeocodingCollection::make($dto),
        ]);
    }
}
