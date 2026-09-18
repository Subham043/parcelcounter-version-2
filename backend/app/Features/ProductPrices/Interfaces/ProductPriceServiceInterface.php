<?php

namespace App\Features\ProductPrices\Interfaces;

use App\Features\ProductPrices\DTO\ProductPriceDTO;
use App\Features\ProductPrices\Models\ProductPrice;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductPriceServiceInterface
{
    public function paginate(int $product_id, int $total = 10): LengthAwarePaginator;
    public function create(ProductPriceDTO $data, int $product_id): ProductPrice;
    public function update(ProductPriceDTO $data, ProductPrice $price): ProductPrice;
    public function getById(int $product_id, int $id): ProductPrice;
    public function delete(ProductPrice $price): ProductPrice;
}
