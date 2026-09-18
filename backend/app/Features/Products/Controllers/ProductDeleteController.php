<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Products\Resources\ProductCollection;

class ProductDeleteController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Delete a product
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $product = $this->productService->getById($id);
        try {
            //code...
            $this->productService->delete($product);
            return response()->json(["message" => "Product deleted successfully.", "data" => ProductCollection::make($product)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
