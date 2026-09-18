<?php

namespace App\Features\Products\Interfaces;

use App\Features\Products\DTO\ProductCategoryIdDTO;
use App\Features\Products\DTO\ProductSubCategoryIdDTO;
use App\Features\Products\DTO\ProductTaxIdDTO;
use App\Features\Products\DTO\ProductDTO;
use App\Features\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function paginate(Int $total = 10, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false): LengthAwarePaginator;
    public function create(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO, ProductSubCategoryIdDTO $subCategoryIdDTO, ProductTaxIdDTO $taxIdDTO): Product;
    public function update(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO, ProductSubCategoryIdDTO $subCategoryIdDTO, ProductTaxIdDTO $taxIdDTO, Product $product): Product;
    public function getById(int $id, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false): Product;
    public function getBySlug(string $slug, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false): Product;
    public function delete(Product $product): Product;
    public function toggleActive(Product $product): Product;
    public function exportProducts(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
