<?php

namespace App\Features\Products\Interfaces;

use App\Features\Products\DTO\ProductCategoryIdDTO;
use App\Features\Products\DTO\ProductDTO;
use App\Features\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function paginate(Int $total = 10, bool $withCategory = false): LengthAwarePaginator;
    public function create(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO): Product;
    public function update(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO, Product $product): Product;
    public function getById(int $id, bool $withCategory = false): Product;
    public function getBySlug(string $slug, bool $withCategory = false): Product;
    public function delete(Product $product): Product;
    public function toggleActive(Product $product): Product;
    public function exportProducts(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
