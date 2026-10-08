<?php

namespace App\Features\BillingInformations\Controllers;

use App\Features\BillingInformations\DTO\BillingInformationFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Features\BillingInformations\Requests\BillingInformationFilterRequest;

class BillingInformationExportController extends Controller
{
    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Download all informations as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(BillingInformationFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->informationService->exportBillingInformations(BillingInformationFilterDTO::fromRequest($request));
    }
}
