<?php

namespace App\Features\PaymentOptions\Controllers;

use App\Features\PaymentOptions\DTO\PaymentOptionDTO;
use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\PaymentOptions\Requests\PaymentOptionUpdatePostRequest;
use App\Features\PaymentOptions\Resources\PaymentOptionCollection;

class PaymentOptionUpdateController extends Controller
{
    public function __construct(private PaymentOptionServiceInterface $optionService) {}

    /**
     * Update an option
     *
     * @param PaymentOptionUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PaymentOptionUpdatePostRequest $request, $id)
    {
        $option = $this->optionService->getById($id);
        try {
            //code...
            $option = $this->optionService->update(
                PaymentOptionDTO::fromRequest($request),
                $option
            );
            return response()->json(["message" => "Payment option updated successfully.", "data" => PaymentOptionCollection::make($option)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
