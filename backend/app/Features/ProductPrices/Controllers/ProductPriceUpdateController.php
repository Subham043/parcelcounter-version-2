<?php

namespace App\Features\ProductPrices\Controllers;

use App\Features\ProductPrices\DTO\ProductPriceDTO;
use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductPrices\Requests\ProductPricePostRequest;
use App\Features\ProductPrices\Resources\ProductPriceCollection;

class ProductPriceUpdateController extends Controller
{
    public function __construct(private ProductPriceServiceInterface $priceService) {}

    /**
     * Update an price
     *
     * @param int $product_id
     * @param ProductPricePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id, ProductPricePostRequest $request)
    {
        $price = $this->priceService->getById($product_id, $id);
        try {
            //code...
            $updated_price = $this->priceService->update(
                ProductPriceDTO::fromRequest($request),
                $price
            );
            return response()->json(["message" => "Product price updated successfully.", "data" => ProductPriceCollection::make($updated_price)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
