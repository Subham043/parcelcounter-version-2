<?php

namespace App\Features\ProductStocks\Controllers;

use App\Features\ProductStocks\DTO\ProductStockFilterDTO;
use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Features\ProductStocks\Requests\ProductStockFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ProductStocks\Resources\ProductStockCollection;

class ProductStockPaginateController extends Controller
{
    public function __construct(private ProductStockServiceInterface $stockService) {}

    /**
     * Returns a paginated collection of stocks.
     *
     * @param int $product_id
     * @param ProductStockFilterRequest $request
     * @return ProductStockCollection
     */
    public function index($product_id, ProductStockFilterRequest $request)
    {
        $data = $this->stockService->paginate($product_id, ProductStockFilterDTO::fromRequest($request));
        return ProductStockCollection::collection($data);
    }
}
