<?php

namespace App\Features\ProductPrices\Controllers;

use App\Features\ProductPrices\DTO\ProductPriceFilterDTO;
use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Features\ProductPrices\Requests\ProductPriceFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ProductPrices\Resources\ProductPriceCollection;

class ProductPricePaginateController extends Controller
{
    public function __construct(private ProductPriceServiceInterface $priceService) {}

    /**
     * Returns a paginated collection of prices.
     *
     * @param int $product_id
     * @param ProductPriceFilterRequest $request
     * @return ProductPriceCollection
     */
    public function index($product_id, ProductPriceFilterRequest $request)
    {
        $data = $this->priceService->paginate($product_id, ProductPriceFilterDTO::fromRequest($request));
        return ProductPriceCollection::collection($data);
    }
}
