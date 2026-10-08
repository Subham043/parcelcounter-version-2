<?php

namespace App\Features\ProductImages\Controllers;

use App\Features\ProductImages\DTO\ProductImageFilterDTO;
use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Features\ProductImages\Requests\ProductImageFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ProductImages\Resources\ProductImageCollection;

class ProductImagePaginateController extends Controller
{
    public function __construct(private ProductImageServiceInterface $imageService) {}

    /**
     * Returns a paginated collection of images.
     *
     * @param int $product_id
     * @param ProductImageFilterRequest $request
     * @return ProductImageCollection
     */
    public function index($product_id, ProductImageFilterRequest $request)
    {
        $data = $this->imageService->paginate($product_id, ProductImageFilterDTO::fromRequest($request));
        return ProductImageCollection::collection($data);
    }
}
