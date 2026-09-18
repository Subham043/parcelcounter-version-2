<?php

namespace App\Features\ProductImages\Controllers;

use App\Features\ProductImages\DTO\ProductImageDTO;
use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductImages\Requests\ProductImageCreatePostRequest;
use App\Features\ProductImages\Resources\ProductImageCollection;

class ProductImageCreateController extends Controller
{

    public function __construct(private ProductImageServiceInterface $imageService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($product_id, ProductImageCreatePostRequest $request)
    {
        try {
            //code...
            $image = $this->imageService->create(
                ProductImageDTO::fromRequest($request),
                $product_id,
            );
            return response()->json([
                "message" => "Product image created successfully.",
                "data" => ProductImageCollection::make($image),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
