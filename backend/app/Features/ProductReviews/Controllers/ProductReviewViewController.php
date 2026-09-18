<?php

namespace App\Features\ProductReviews\Controllers;

use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductReviews\Resources\ProductReviewCollection;

class ProductReviewViewController extends Controller
{
    public function __construct(private ProductReviewServiceInterface $reviewService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $product_id
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($product_id, $id)
    {
        $review = $this->reviewService->getById($product_id, $id);
        return response()->json(["message" => "Product review fetched successfully.", "data" => ProductReviewCollection::make($review)], 200);
    }
}
