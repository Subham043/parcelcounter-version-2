<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\DTO\ProductCategoryIdDTO;
use App\Features\Products\DTO\ProductColorDTO;
use App\Features\Products\DTO\ProductDTO;
use App\Features\Products\DTO\ProductPriceDTO;
use App\Features\Products\DTO\ProductSpecificationDTO;
use App\Features\Products\DTO\ProductStockDTO;
use App\Features\Products\DTO\ProductSubCategoryIdDTO;
use App\Features\Products\DTO\ProductTaxIdDTO;
use App\Features\Products\DTO\ProductVideoDTO;
use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Products\Requests\ProductUpdatePostRequest;
use App\Features\Products\Resources\ProductCollection;

class ProductUpdateController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Update an product
     *
     * @param ProductUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(ProductUpdatePostRequest $request, $id)
    {
        $product = $this->productService->getById($id);
        try {
            //code...
            $updated_product = $this->productService->update(
                ProductDTO::fromRequest($request),
                ProductCategoryIdDTO::fromRequest($request),
                ProductSubCategoryIdDTO::fromRequest($request),
                ProductTaxIdDTO::fromRequest($request),
                ProductSpecificationDTO::fromRequest($request),
                ProductPriceDTO::fromRequest($request),
                ProductStockDTO::fromRequest($request),
                ProductColorDTO::fromRequest($request),
                ProductVideoDTO::fromRequest($request),
                $product
            );
            return response()->json(["message" => "Product updated successfully.", "data" => ProductCollection::make($updated_product)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
