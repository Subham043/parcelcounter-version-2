<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\DTO\ProductFilterDTO;
use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Features\Products\Requests\ProductFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Products\Resources\ProductCollection;

class ProductPaginateController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Returns a paginated collection of products.
     *
     * @param ProductFilterRequest $request
     * @return ProductCollection
     */
    public function index(ProductFilterRequest $request)
    {
        $data = $this->productService->paginate(ProductFilterDTO::fromRequest($request));
        return ProductCollection::collection($data);
    }
}
