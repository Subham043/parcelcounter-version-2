<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Features\PaymentOptions\DTO\PaymentOptionFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Features\PaymentOptions\Requests\PaymentOptionFilterRequest;

class PaymentOptionExportController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Download all options as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(PaymentOptionFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->optionService->exportPaymentOptions(PaymentOptionFilterDTO::fromRequest($request));
    }
}
