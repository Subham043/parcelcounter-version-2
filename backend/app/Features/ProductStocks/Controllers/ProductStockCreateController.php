<?php

namespace App\Features\ProductStocks\Controllers;

use App\Features\ProductStocks\DTO\ProductStockDTO;
use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductStocks\Requests\ProductStockPostRequest;
use App\Features\ProductStocks\Resources\ProductStockCollection;

class ProductStockCreateController extends Controller
{

    public function __construct(private ProductStockServiceInterface $stockService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($product_id, ProductStockPostRequest $request)
    {
        try {
            //code...
            $stock = $this->stockService->create(
                ProductStockDTO::fromRequest($request),
                $product_id,
            );
            return response()->json([
                "message" => "Product stock created successfully.",
                "data" => ProductStockCollection::make($stock),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
