<?php

namespace App\Features\ProductReviews\Controllers;

use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductReviews\Resources\ProductReviewCollection;

class ProductReviewDeleteController extends Controller
{
    public function __construct(private ProductReviewServiceInterface $reviewService) {}

    /**
     * Delete a review
     *
     * @param int $product_id
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($product_id, $id)
    {
        $review = $this->reviewService->getById($product_id, $id);
        try {
            //code...
            $this->reviewService->delete($review);
            return response()->json(["message" => "Product review deleted successfully.", "data" => ProductReviewCollection::make($review)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
