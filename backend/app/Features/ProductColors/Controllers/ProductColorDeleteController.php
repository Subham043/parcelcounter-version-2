<?php

namespace App\Features\ProductColors\Controllers;

use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductColors\Resources\ProductColorCollection;

class ProductColorDeleteController extends Controller
{
    public function __construct(private ProductColorServiceInterface $colorService) {}

    /**
     * Delete a color
     *
     * @param int $product_id
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id)
    {
        $color = $this->colorService->getById($product_id, $id);
        try {
            //code...
            $this->colorService->delete($color);
            return response()->json(["message" => "Product color deleted successfully.", "data" => ProductColorCollection::make($color)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
