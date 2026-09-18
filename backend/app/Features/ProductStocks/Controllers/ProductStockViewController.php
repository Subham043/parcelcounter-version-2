<?php

namespace App\Features\ProductStocks\Controllers;

use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductStocks\Resources\ProductStockCollection;

class ProductStockViewController extends Controller
{
    public function __construct(private ProductStockServiceInterface $stockService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($product_id, $id)
    {
        $stock = $this->stockService->getById($product_id, $id);
        return response()->json(["message" => "Product stock fetched successfully.", "data" => ProductStockCollection::make($stock)], 200);
    }
}
