<?php

namespace App\Features\ProductStocks\Interfaces;

use App\Features\ProductStocks\DTO\ProductStockDTO;
use App\Features\ProductStocks\Models\ProductStock;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductStockServiceInterface
{
    public function paginate(int $product_id, int $total = 10): LengthAwarePaginator;
    public function create(ProductStockDTO $data, int $product_id): ProductStock;
    public function update(ProductStockDTO $data, ProductStock $stock): ProductStock;
    public function getById(int $product_id, int $id): ProductStock;
    public function delete(ProductStock $stock): ProductStock;
}
