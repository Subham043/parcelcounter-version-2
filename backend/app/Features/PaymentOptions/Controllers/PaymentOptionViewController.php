<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Resources\PaymentOptionCollection;

class PaymentOptionViewController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $option = $this->optionService->getById($id);
        return response()->json(["message" => "Payment option fetched successfully.", "data" => PaymentOptionCollection::make($option)], 200);
    }
}
