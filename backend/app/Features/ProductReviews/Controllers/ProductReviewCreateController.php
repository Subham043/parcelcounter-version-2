<?php

namespace App\Features\ProductReviews\Controllers;

use App\Features\ProductReviews\DTO\ProductReviewDTO;
use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductReviews\Requests\ProductReviewPostRequest;
use App\Features\ProductReviews\Resources\ProductReviewCollection;

class ProductReviewCreateController extends Controller
{

    public function __construct(private ProductReviewServiceInterface $reviewService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param int $product_id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index($product_id, ProductReviewPostRequest $request)
    {
        try {
            //code...
            $review = $this->reviewService->create(
                ProductReviewDTO::fromRequest($request),
                $product_id,
            );
            return response()->json([
                "message" => "Product review created successfully.",
                "data" => ProductReviewCollection::make($review),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
