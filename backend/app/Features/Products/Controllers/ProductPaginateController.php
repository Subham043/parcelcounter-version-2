<?php

namespace App\Features\Products\Controllers;

use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Products\Resources\ProductCollection;
use Illuminate\Http\Request;

class ProductPaginateController extends Controller
{
    public function __construct(private ProductServiceInterface $productService) {}

    /**
     * Returns a paginated collection of products.
     *
     * @param Request $request
     * @return ProductCollection
     */
    public function index(Request $request)
    {
        $data = $this->productService->paginate($request->total ?? 10, $request->query('include-category') == 'yes', $request->query('include-sub-category') == 'yes', $request->query('include-tax') == 'yes', $request->query('include-specification') == 'yes', $request->query('include-image') == 'yes', $request->query('include-video') == 'yes', $request->query('include-color') == 'yes', $request->query('include-price') == 'yes', $request->query('include-stock') == 'yes', $request->query('include-latest-stock') == 'yes', $request->query('include-review') == 'yes');
        return ProductCollection::collection($data);
    }
}
