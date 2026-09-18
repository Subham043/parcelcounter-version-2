<?php

namespace App\Features\ProductColors\Controllers;

use App\Features\ProductColors\DTO\ProductColorDTO;
use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductColors\Requests\ProductColorPostRequest;
use App\Features\ProductColors\Resources\ProductColorCollection;

class ProductColorCreateController extends Controller
{

    public function __construct(private ProductColorServiceInterface $colorService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($product_id, ProductColorPostRequest $request)
    {
        try {
            //code...
            $color = $this->colorService->create(
                ProductColorDTO::fromRequest($request),
                $product_id,
            );
            return response()->json([
                "message" => "Product color created successfully.",
                "data" => ProductColorCollection::make($color),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
