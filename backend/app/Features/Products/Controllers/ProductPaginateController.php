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
        $data = $this->productService->paginate($request->total ?? 10, $request->query('include-category') == 'yes');
        return ProductCollection::collection($data);
    }
}
