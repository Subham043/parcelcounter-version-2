<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\DTO\FeatureFilterDTO;
use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Features\Features\Requests\FeatureFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Features\Resources\FeatureCollection;

class FeaturePaginateController extends Controller
{
    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Returns a paginated collection of features.
     *
     * @param FeatureFilterRequest $request
     * @return FeatureCollection
     */
    public function index(FeatureFilterRequest $request)
    {
        $data = $this->featureService->paginate(FeatureFilterDTO::fromRequest($request));
        return FeatureCollection::collection($data);
    }
}
