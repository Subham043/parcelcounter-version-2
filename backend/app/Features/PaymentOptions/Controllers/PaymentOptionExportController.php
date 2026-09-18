<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;

class PaymentOptionExportController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Download all options as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->optionService->exportPaymentOptions();
    }
}
