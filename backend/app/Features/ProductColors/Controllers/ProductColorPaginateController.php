<?php

namespace App\Features\ProductColors\Controllers;

use App\Features\ProductColors\DTO\ProductColorFilterDTO;
use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Features\ProductColors\Requests\ProductColorFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ProductColors\Resources\ProductColorCollection;

class ProductColorPaginateController extends Controller
{
    public function __construct(private ProductColorServiceInterface $colorService) {}

    /**
     * Returns a paginated collection of colors.
     *
     * @param int $product_id
     * @param ProductColorFilterRequest $request
     * @return ProductColorCollection
     */
    public function index($product_id, ProductColorFilterRequest $request)
    {
        $data = $this->colorService->paginate($product_id, ProductColorFilterDTO::fromRequest($request));
        return ProductColorCollection::collection($data);
    }
}
