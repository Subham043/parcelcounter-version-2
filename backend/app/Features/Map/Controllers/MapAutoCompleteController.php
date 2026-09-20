<?php

namespace App\Features\Map\Controllers;

use App\Features\Map\DTO\AutoCompleteRequestDTO;
use App\Features\Map\DTO\AutoCompleteResponseDTO;
use App\Features\Map\Interfaces\MapServiceInterface;
use App\Features\Map\Requests\AutoCompletePostRequest;
use App\Features\Map\Resources\AutoCompleteCollection;
use App\Http\Controllers\Controller;

class MapAutoCompleteController extends Controller
{
    public function __construct(private MapServiceInterface $mapService) {}

    /**
     * Display the specified resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function index(AutoCompletePostRequest $request)
    {
        $data = $this->mapService->getAutocomplete(AutoCompleteRequestDTO::fromRequest($request));
        $data = collect($data)
        ->map(fn ($item) => AutoCompleteResponseDTO::fromOla($item));

        return response()->json([
            'message' => 'Autocomplete data retrieved successfully.',
            'data' => AutoCompleteCollection::collection($data),
        ], 200);
    }
}
