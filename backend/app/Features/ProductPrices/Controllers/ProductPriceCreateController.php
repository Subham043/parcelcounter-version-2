<?php

namespace App\Features\ProductPrices\Controllers;

use App\Features\ProductPrices\DTO\ProductPriceDTO;
use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductPrices\Requests\ProductPricePostRequest;
use App\Features\ProductPrices\Resources\ProductPriceCollection;

class ProductPriceCreateController extends Controller
{

    public function __construct(private ProductPriceServiceInterface $priceService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($product_id, ProductPricePostRequest $request)
    {
        try {
            //code...
            $price = $this->priceService->create(
                ProductPriceDTO::fromRequest($request),
                $product_id,
            );
            return response()->json([
                "message" => "Product price created successfully.",
                "data" => ProductPriceCollection::make($price),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
