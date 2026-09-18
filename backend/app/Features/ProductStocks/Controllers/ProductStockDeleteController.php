<?php

namespace App\Features\ProductStocks\Controllers;

use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductStocks\Resources\ProductStockCollection;

class ProductStockDeleteController extends Controller
{
    public function __construct(private ProductStockServiceInterface $stockService) {}

    /**
     * Delete a stock
     *
     * @param int $product_id
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id)
    {
        $stock = $this->stockService->getById($product_id, $id);
        try {
            //code...
            $this->stockService->delete($stock);
            return response()->json(["message" => "Product stock deleted successfully.", "data" => ProductStockCollection::make($stock)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
