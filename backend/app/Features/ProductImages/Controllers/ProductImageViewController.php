<?php

namespace App\Features\ProductImages\Controllers;

use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductImages\Resources\ProductImageCollection;

class ProductImageViewController extends Controller
{
    public function __construct(private ProductImageServiceInterface $imageService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($product_id, $id)
    {
        $image = $this->imageService->getById($product_id, $id);
        return response()->json(["message" => "Product image fetched successfully.", "data" => ProductImageCollection::make($image)], 200);
    }
}
