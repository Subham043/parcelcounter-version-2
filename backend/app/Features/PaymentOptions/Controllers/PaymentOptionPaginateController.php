<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Features\PaymentOptions\DTO\PaymentOptionFilterDTO;
use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Features\PaymentOptions\Requests\PaymentOptionFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Resources\PaymentOptionCollection;

class PaymentOptionPaginateController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Returns a paginated collection of options.
     *
     * @param PaymentOptionFilterRequest $request
     * @return PaymentOptionCollection
     */
    public function index(PaymentOptionFilterRequest $request)
    {
        $data = $this->optionService->paginate(PaymentOptionFilterDTO::fromRequest($request));
        return PaymentOptionCollection::collection($data);
    }
}
