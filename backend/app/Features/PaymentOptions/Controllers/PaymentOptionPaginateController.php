<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Resources\PaymentOptionCollection;
use Illuminate\Http\Request;

class PaymentOptionPaginateController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Returns a paginated collection of options.
     *
     * @param Request $request
     * @return PaymentOptionCollection
     */
    public function index(Request $request)
    {
        $data = $this->optionService->paginate($request->total ?? 10);
        return PaymentOptionCollection::collection($data);
    }
}
