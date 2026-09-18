<?php

namespace App\Features\ProductColors\Controllers;

use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductColors\Resources\ProductColorCollection;
use Illuminate\Http\Request;

class ProductColorPaginateController extends Controller
{
    public function __construct(private ProductColorServiceInterface $colorService) {}

    /**
     * Returns a paginated collection of colors.
     *
     * @param int $product_id
     * @param Request $request
     * @return ProductColorCollection
     */
    public function index($product_id, Request $request)
    {
        $data = $this->colorService->paginate($product_id, $request->total ?? 10);
        return ProductColorCollection::collection($data);
    }
}
