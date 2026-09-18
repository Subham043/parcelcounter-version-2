<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Features\Resources\FeatureCollection;
use Illuminate\Http\Request;

class FeaturePaginateController extends Controller
{
    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Returns a paginated collection of features.
     *
     * @param Request $request
     * @return FeatureCollection
     */
    public function index(Request $request)
    {
        $data = $this->featureService->paginate($request->total ?? 10);
        return FeatureCollection::collection($data);
    }
}
