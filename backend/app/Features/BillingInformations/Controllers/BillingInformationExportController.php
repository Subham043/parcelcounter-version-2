<?php

namespace App\Features\BillingInformations\Controllers;

use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;

class BillingInformationExportController extends Controller
{
    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Download all informations as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->informationService->exportBillingInformations();
    }
}
