<?php

namespace App\Features\ProductReviews\Controllers;

use App\Features\ProductReviews\DTO\ProductReviewFilterDTO;
use App\Features\ProductReviews\Interfaces\ProductReviewServiceInterface;
use App\Features\ProductReviews\Requests\ProductReviewFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ProductReviews\Resources\ProductReviewCollection;

class ProductReviewPaginateController extends Controller
{
    public function __construct(private ProductReviewServiceInterface $reviewService) {}

    /**
     * Returns a paginated collection of reviews.
     *
     * @param int $product_id
     * @param ProductReviewFilterRequest $request
     * @return ProductReviewCollection
     */
    public function index($product_id, ProductReviewFilterRequest $request)
    {
        $data = $this->reviewService->paginate($product_id, ProductReviewFilterDTO::fromRequest($request));
        return ProductReviewCollection::collection($data);
    }
}
