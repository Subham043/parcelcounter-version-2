<?php

namespace App\Features\ProductSpecifications\Controllers;

use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductSpecifications\Resources\ProductSpecificationCollection;

class ProductSpecificationViewController extends Controller
{
    public function __construct(private ProductSpecificationServiceInterface $specificationService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($product_id, $id)
    {
        $specification = $this->specificationService->getById($product_id, $id);
        return response()->json(["message" => "Product specification fetched successfully.", "data" => ProductSpecificationCollection::make($specification)], 200);
    }
}
