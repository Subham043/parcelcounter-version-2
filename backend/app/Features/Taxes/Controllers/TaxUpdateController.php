<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\DTO\TaxDTO;
use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Requests\TaxUpdatePostRequest;
use App\Features\Taxes\Resources\TaxCollection;

class TaxUpdateController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Update an tax
     *
     * @param TaxUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TaxUpdatePostRequest $request, $id)
    {
        $tax = $this->taxService->getById($id);
        try {
            //code...
            $updated_tax = $this->taxService->update(
                TaxDTO::fromRequest($request),
                $tax
            );
            return response()->json(["message" => "Tax updated successfully.", "data" => TaxCollection::make($updated_tax)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
