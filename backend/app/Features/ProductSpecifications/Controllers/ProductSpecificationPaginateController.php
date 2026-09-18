<?php

namespace App\Features\ProductSpecifications\Controllers;

use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductSpecifications\Resources\ProductSpecificationCollection;
use Illuminate\Http\Request;

class ProductSpecificationPaginateController extends Controller
{
    public function __construct(private ProductSpecificationServiceInterface $specificationService) {}

    /**
     * Returns a paginated collection of specifications.
     *
     * @param int $product_id
     * @param Request $request
     * @return ProductSpecificationCollection
     */
    public function index($product_id, Request $request)
    {
        $data = $this->specificationService->paginate($product_id, $request->total ?? 10);
        return ProductSpecificationCollection::collection($data);
    }
}
