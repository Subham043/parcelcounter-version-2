<?php

namespace App\Features\ProductImages\Controllers;

use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductImages\Resources\ProductImageCollection;
use Illuminate\Http\Request;

class ProductImagePaginateController extends Controller
{
    public function __construct(private ProductImageServiceInterface $imageService) {}

    /**
     * Returns a paginated collection of images.
     *
     * @param int $product_id
     * @param Request $request
     * @return ProductImageCollection
     */
    public function index($product_id, Request $request)
    {
        $data = $this->imageService->paginate($product_id, $request->total ?? 10);
        return ProductImageCollection::collection($data);
    }
}
