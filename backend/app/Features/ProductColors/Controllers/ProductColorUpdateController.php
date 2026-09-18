<?php

namespace App\Features\ProductColors\Controllers;

use App\Features\ProductColors\DTO\ProductColorDTO;
use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductColors\Requests\ProductColorPostRequest;
use App\Features\ProductColors\Resources\ProductColorCollection;

class ProductColorUpdateController extends Controller
{
    public function __construct(private ProductColorServiceInterface $colorService) {}

    /**
     * Update an color
     *
     * @param int $product_id
     * @param ProductColorPostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id, ProductColorPostRequest $request)
    {
        $color = $this->colorService->getById($product_id, $id);
        try {
            //code...
            $updated_color = $this->colorService->update(
                ProductColorDTO::fromRequest($request),
                $color
            );
            return response()->json(["message" => "Product color updated successfully.", "data" => ProductColorCollection::make($updated_color)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
