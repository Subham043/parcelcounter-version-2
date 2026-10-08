<?php

namespace App\Features\ProductSpecifications\Controllers;

use App\Features\ProductSpecifications\DTO\ProductSpecificationFilterDTO;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Features\ProductSpecifications\Requests\ProductSpecificationFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ProductSpecifications\Resources\ProductSpecificationCollection;

class ProductSpecificationPaginateController extends Controller
{
    public function __construct(private ProductSpecificationServiceInterface $specificationService) {}

    /**
     * Returns a paginated collection of specifications.
     *
     * @param int $product_id
     * @param ProductSpecificationFilterRequest $request
     * @return ProductSpecificationCollection
     */
    public function index($product_id, ProductSpecificationFilterRequest $request)
    {
        $data = $this->specificationService->paginate($product_id, ProductSpecificationFilterDTO::fromRequest($request));
        return ProductSpecificationCollection::collection($data);
    }
}
