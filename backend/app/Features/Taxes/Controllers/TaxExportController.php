<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\DTO\TaxFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Features\Taxes\Requests\TaxFilterRequest;

class TaxExportController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Download all taxs as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(TaxFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->taxService->exportTaxes(TaxFilterDTO::fromRequest($request));
    }
}
