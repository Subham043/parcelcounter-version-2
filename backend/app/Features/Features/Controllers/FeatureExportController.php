<?php

namespace App\Features\Features\Controllers;

use App\Features\Features\DTO\FeatureFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Features\Features\Requests\FeatureFilterRequest;

class FeatureExportController extends Controller
{
    public function __construct(private FeatureServiceInterface $featureService) {}

    /**
     * Download all features as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(FeatureFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->featureService->exportFeatures(FeatureFilterDTO::fromRequest($request));
    }
}
