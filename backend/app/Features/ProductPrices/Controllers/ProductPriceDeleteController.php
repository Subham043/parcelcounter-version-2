<?php

namespace App\Features\ProductPrices\Controllers;

use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductPrices\Resources\ProductPriceCollection;

class ProductPriceDeleteController extends Controller
{
    public function __construct(private ProductPriceServiceInterface $priceService) {}

    /**
     * Delete a price
     *
     * @param int $product_id
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id)
    {
        $price = $this->priceService->getById($product_id, $id);
        try {
            //code...
            $this->priceService->delete($price);
            return response()->json(["message" => "Product price deleted successfully.", "data" => ProductPriceCollection::make($price)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
