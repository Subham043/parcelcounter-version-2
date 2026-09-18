<?php

namespace App\Features\ProductImages\Controllers;

use App\Features\ProductImages\DTO\ProductImageDTO;
use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductImages\Requests\ProductImageUpdatePostRequest;
use App\Features\ProductImages\Resources\ProductImageCollection;

class ProductImageUpdateController extends Controller
{
    public function __construct(private ProductImageServiceInterface $imageService) {}

    /**
     * Update an image
     *
     * @param int $product_id
     * @param ProductImageUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id, ProductImageUpdatePostRequest $request)
    {
        $image = $this->imageService->getById($product_id, $id);
        try {
            //code...
            $updated_image = $this->imageService->update(
                ProductImageDTO::fromRequest($request),
                $image
            );
            return response()->json(["message" => "Product image updated successfully.", "data" => ProductImageCollection::make($updated_image)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
