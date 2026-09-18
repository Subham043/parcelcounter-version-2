<?php

namespace App\Features\ProductPrices\Controllers;

use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductPrices\Resources\ProductPriceCollection;

class ProductPriceViewController extends Controller
{
    public function __construct(private ProductPriceServiceInterface $priceService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($product_id, $id)
    {
        $price = $this->priceService->getById($product_id, $id);
        return response()->json(["message" => "Product price fetched successfully.", "data" => ProductPriceCollection::make($price)], 200);
    }
}
