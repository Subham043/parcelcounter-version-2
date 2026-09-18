<?php

namespace App\Features\ProductImages\Interfaces;

use App\Features\ProductImages\DTO\ProductImageDTO;
use App\Features\ProductImages\Models\ProductImage;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductImageServiceInterface
{
    public function paginate(int $product_id, int $total = 10): LengthAwarePaginator;
    public function create(ProductImageDTO $data, int $product_id): ProductImage;
    public function update(ProductImageDTO $data, ProductImage $image): ProductImage;
    public function getById(int $product_id, int $id): ProductImage;
    public function delete(ProductImage $image): ProductImage;
}
