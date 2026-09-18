<?php

namespace App\Features\ProductStocks\Controllers;

use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductStocks\Resources\ProductStockCollection;
use Illuminate\Http\Request;

class ProductStockPaginateController extends Controller
{
    public function __construct(private ProductStockServiceInterface $stockService) {}

    /**
     * Returns a paginated collection of stocks.
     *
     * @param int $product_id
     * @param Request $request
     * @return ProductStockCollection
     */
    public function index($product_id, Request $request)
    {
        $data = $this->stockService->paginate($product_id, $request->total ?? 10);
        return ProductStockCollection::collection($data);
    }
}
