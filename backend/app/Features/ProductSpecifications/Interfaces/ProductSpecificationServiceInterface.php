<?php

namespace App\Features\ProductSpecifications\Interfaces;

use App\Features\ProductSpecifications\DTO\ProductSpecificationDTO;
use App\Features\ProductSpecifications\Models\ProductSpecification;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductSpecificationServiceInterface
{
    public function paginate(int $product_id, int $total = 10): LengthAwarePaginator;
    public function create(ProductSpecificationDTO $data, int $product_id): ProductSpecification;
    public function update(ProductSpecificationDTO $data, ProductSpecification $specification): ProductSpecification;
    public function getById(int $product_id, int $id): ProductSpecification;
    public function delete(ProductSpecification $specification): ProductSpecification;
}
