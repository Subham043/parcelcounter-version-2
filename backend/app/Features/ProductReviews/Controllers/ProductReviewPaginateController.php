<?php

namespace App\Features\ProductReviews\Controllers;

use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductReviews\Resources\ProductReviewCollection;
use Illuminate\Http\Request;

class ProductReviewPaginateController extends Controller
{
    public function __construct(private ProductReviewServiceInterface $reviewService) {}

    /**
     * Returns a paginated collection of reviews.
     *
     * @param int $product_id
     * @param Request $request
     * @return ProductReviewCollection
     */
    public function index($product_id, Request $request)
    {
        $data = $this->reviewService->paginate($product_id, $request->total ?? 10);
        return ProductReviewCollection::collection($data);
    }
}
