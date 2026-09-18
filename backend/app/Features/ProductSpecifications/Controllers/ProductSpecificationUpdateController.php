<?php

namespace App\Features\ProductSpecifications\Controllers;

use App\Features\ProductSpecifications\DTO\ProductSpecificationDTO;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductSpecifications\Requests\ProductSpecificationPostRequest;
use App\Features\ProductSpecifications\Resources\ProductSpecificationCollection;

class ProductSpecificationUpdateController extends Controller
{
    public function __construct(private ProductSpecificationServiceInterface $specificationService) {}

    /**
     * Update an specification
     *
     * @param int $product_id
     * @param ProductSpecificationPostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id, ProductSpecificationPostRequest $request)
    {
        $specification = $this->specificationService->getById($product_id, $id);
        try {
            //code...
            $updated_specification = $this->specificationService->update(
                ProductSpecificationDTO::fromRequest($request),
                $specification
            );
            return response()->json(["message" => "Product specification updated successfully.", "data" => ProductSpecificationCollection::make($updated_specification)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
