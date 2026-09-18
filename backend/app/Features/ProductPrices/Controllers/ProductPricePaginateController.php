<?php

namespace App\Features\ProductPrices\Controllers;

use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ProductPrices\Resources\ProductPriceCollection;
use Illuminate\Http\Request;

class ProductPricePaginateController extends Controller
{
    public function __construct(private ProductPriceServiceInterface $priceService) {}

    /**
     * Returns a paginated collection of prices.
     *
     * @param int $product_id
     * @param Request $request
     * @return ProductPriceCollection
     */
    public function index($product_id, Request $request)
    {
        $data = $this->priceService->paginate($product_id, $request->total ?? 10);
        return ProductPriceCollection::collection($data);
    }
}
