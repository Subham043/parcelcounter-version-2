<?php

namespace App\Features\ProductSpecifications\Controllers;

use App\Features\ProductSpecifications\DTO\ProductSpecificationDTO;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductSpecifications\Requests\ProductSpecificationPostRequest;
use App\Features\ProductSpecifications\Resources\ProductSpecificationCollection;

class ProductSpecificationCreateController extends Controller
{

    public function __construct(private ProductSpecificationServiceInterface $specificationService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($product_id, ProductSpecificationPostRequest $request)
    {
        try {
            //code...
            $specification = $this->specificationService->create(
                ProductSpecificationDTO::fromRequest($request),
                $product_id,
            );
            return response()->json([
                "message" => "Product specification created successfully.",
                "data" => ProductSpecificationCollection::make($specification),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
