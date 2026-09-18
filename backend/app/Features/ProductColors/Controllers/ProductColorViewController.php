<?php

namespace App\Features\ProductColors\Controllers;

use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductColors\Resources\ProductColorCollection;

class ProductColorViewController extends Controller
{
    public function __construct(private ProductColorServiceInterface $colorService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($product_id, $id)
    {
        $color = $this->colorService->getById($product_id, $id);
        return response()->json(["message" => "Product color fetched successfully.", "data" => ProductColorCollection::make($color)], 200);
    }
}
