<?php

namespace App\Features\ProductStocks\Controllers;

use App\Features\ProductStocks\DTO\ProductStockDTO;
use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductStocks\Requests\ProductStockPostRequest;
use App\Features\ProductStocks\Resources\ProductStockCollection;

class ProductStockUpdateController extends Controller
{
    public function __construct(private ProductStockServiceInterface $stockService) {}

    /**
     * Update an stock
     *
     * @param int $product_id
     * @param ProductStockPostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id, ProductStockPostRequest $request)
    {
        $stock = $this->stockService->getById($product_id, $id);
        try {
            //code...
            $updated_stock = $this->stockService->update(
                ProductStockDTO::fromRequest($request),
                $stock
            );
            return response()->json(["message" => "Product stock updated successfully.", "data" => ProductStockCollection::make($updated_stock)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
