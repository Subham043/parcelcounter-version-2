<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\DTO\ProductCategoryIdDTO;
use App\Features\Products\DTO\ProductColorDTO;
use App\Features\Products\DTO\ProductDTO;
use App\Features\Products\DTO\ProductImageDTO;
use App\Features\Products\DTO\ProductPriceDTO;
use App\Features\Products\DTO\ProductSpecificationDTO;
use App\Features\Products\DTO\ProductStockDTO;
use App\Features\Products\DTO\ProductSubCategoryIdDTO;
use App\Features\Products\DTO\ProductTaxIdDTO;
use App\Features\Products\DTO\ProductVideoDTO;
use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Products\Requests\ProductCreatePostRequest;
use App\Features\Products\Resources\ProductCollection;

class ProductCreateController extends Controller
{

    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(ProductCreatePostRequest $request)
    {
        try {
            //code...
            $product = $this->productService->create(
                ProductDTO::fromRequest($request),
                ProductCategoryIdDTO::fromRequest($request),
                ProductSubCategoryIdDTO::fromRequest($request),
                ProductTaxIdDTO::fromRequest($request),
                ProductSpecificationDTO::fromRequest($request),
                ProductPriceDTO::fromRequest($request),
                ProductStockDTO::fromRequest($request),
                ProductColorDTO::fromRequest($request),
                ProductVideoDTO::fromRequest($request),
                ProductImageDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Product created successfully.",
                "data" => ProductCollection::make($product),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
