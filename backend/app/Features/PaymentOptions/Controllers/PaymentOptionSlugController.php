<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Resources\PaymentOptionCollection;

class PaymentOptionSlugController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function index(string $slug)
    {
        $option = $this->optionService->getBySlug($slug);
        return response()->json(["message" => "Payment option fetched successfully.", "data" => PaymentOptionCollection::make($option)], 200);
    }
}
