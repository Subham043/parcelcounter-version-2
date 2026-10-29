<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\DTO\ProductFilterDTO;
use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Features\Products\Requests\ProductFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Products\Resources\ProductCollection;

class ProductSlugController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug, ProductFilterRequest $request)
    {
        $product = $this->productService->getBySlug($slug, ProductFilterDTO::fromRequest($request));
        return response()->json(["message" => "Product fetched successfully.", "data" => ProductCollection::make($product)], 200);
    }
}
