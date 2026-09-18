<?php

namespace App\Features\ProductSpecifications\Controllers;

use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductSpecifications\Resources\ProductSpecificationCollection;

class ProductSpecificationDeleteController extends Controller
{
    public function __construct(private ProductSpecificationServiceInterface $specificationService) {}

    /**
     * Delete a specification
     *
     * @param int $product_id
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id)
    {
        $specification = $this->specificationService->getById($product_id, $id);
        try {
            //code...
            $this->specificationService->delete($specification);
            return response()->json(["message" => "Product specification deleted successfully.", "data" => ProductSpecificationCollection::make($specification)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
