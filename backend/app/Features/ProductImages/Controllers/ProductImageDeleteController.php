<?php

namespace App\Features\ProductImages\Controllers;

use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductImages\Resources\ProductImageCollection;

class ProductImageDeleteController extends Controller
{
    public function __construct(private ProductImageServiceInterface $imageService) {}

    /**
     * Delete a image
     *
     * @param int $product_id
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id)
    {
        $image = $this->imageService->getById($product_id, $id);
        try {
            //code...
            $this->imageService->delete($image);
            return response()->json(["message" => "Product image deleted successfully.", "data" => ProductImageCollection::make($image)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
