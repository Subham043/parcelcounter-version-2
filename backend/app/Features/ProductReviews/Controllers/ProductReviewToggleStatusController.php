<?php

namespace App\Features\ProductReviews\Controllers;

use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductReviews\Resources\ProductReviewCollection;

class ProductReviewToggleStatusController extends Controller
{
    public function __construct(private ProductReviewServiceInterface $reviewService) {}

    /**
     * Toggle the active status of an review.
     *
     * @param int $product_id
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the review by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the review. It returns a JSON response
     * indicating whether the review was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($product_id, $id)
    {
        $review = $this->reviewService->getById($product_id, $id);
        try {
            //code...
            $updated_review = $this->reviewService->toggleActive($review);
            if ($updated_review->is_active) {
                return response()->json(["message" => "Product review is now active.", "data" => ProductReviewCollection::make($updated_review)], 200);
            }
            return response()->json(["message" => "Product review is now inactive.", "data" => ProductReviewCollection::make($updated_review)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
