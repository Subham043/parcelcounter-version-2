<?php

namespace App\Features\Charges\Controllers;

use App\Http\Controllers\Controller;
use App\Features\Charges\Interfaces\ChargeServiceInterface;

class ChargeExportController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Download all charges as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->chargeService->exportCharges();
    }
}
