<?php

namespace App\Features\ProductColors\Interfaces;

use App\Features\ProductColors\DTO\ProductColorDTO;
use App\Features\ProductColors\Models\ProductColor;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductColorServiceInterface
{
    public function paginate(int $product_id, int $total = 10): LengthAwarePaginator;
    public function create(ProductColorDTO $data, int $product_id): ProductColor;
    public function update(ProductColorDTO $data, ProductColor $color): ProductColor;
    public function getById(int $product_id, int $id): ProductColor;
    public function delete(ProductColor $color): ProductColor;
}
