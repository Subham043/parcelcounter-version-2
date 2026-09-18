<?php

namespace App\Features\ProductReviews\Controllers;

use App\Features\ProductReviews\DTO\ProductReviewDTO;
use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductReviews\Requests\ProductReviewPostRequest;
use App\Features\ProductReviews\Resources\ProductReviewCollection;

class ProductReviewUpdateController extends Controller
{
    public function __construct(private ProductReviewServiceInterface $reviewService) {}

    /**
     * Update an review
     *
     * @param int $product_id
     * @param ProductReviewPostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id, ProductReviewPostRequest $request)
    {
        $review = $this->reviewService->getById($product_id, $id);
        try {
            //code...
            $updated_review = $this->reviewService->update(
                ProductReviewDTO::fromRequest($request),
                $review
            );
            return response()->json(["message" => "Product review updated successfully.", "data" => ProductReviewCollection::make($updated_review)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
