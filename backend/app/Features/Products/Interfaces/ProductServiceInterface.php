<?php

namespace App\Features\Products\Interfaces;

use App\Features\Categories\DTO\CategoryIdDTO;
use App\Features\Products\DTO\ProductColorDTO;
use App\Features\Products\DTO\ProductDTO;
use App\Features\Products\DTO\ProductFilterDTO;
use App\Features\Products\DTO\ProductImageDTO;
use App\Features\Products\DTO\ProductSpecificationDTO;
use App\Features\Products\DTO\ProductPriceDTO;
use App\Features\Products\DTO\ProductStockDTO;
use App\Features\Products\DTO\ProductVideoDTO;
use App\Features\Products\Models\Product;
use App\Features\SubCategories\DTO\SubCategoryIdDTO;
use App\Features\Taxes\DTO\TaxIdDTO;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductServiceInterface
{
    public function paginate(?ProductFilterDTO $dto = null): LengthAwarePaginator;
    public function create(ProductDTO $data, CategoryIdDTO $categoryIdDTO, SubCategoryIdDTO $subCategoryIdDTO, TaxIdDTO $taxIdDTO, ProductSpecificationDTO $specificationDTO, ProductPriceDTO $priceDTO, ProductStockDTO $stockDTO, ProductColorDTO $colorDTO, ProductVideoDTO $videoDTO, ProductImageDTO $imageDTO): Product;
    public function update(ProductDTO $data, CategoryIdDTO $categoryIdDTO, SubCategoryIdDTO $subCategoryIdDTO, TaxIdDTO $taxIdDTO, ProductSpecificationDTO $specificationDTO, ProductPriceDTO $priceDTO, ProductStockDTO $stockDTO, ProductColorDTO $colorDTO, ProductVideoDTO $videoDTO, ProductImageDTO $imageDTO, Product $product): Product;
    public function getById(int $id, ?ProductFilterDTO $dto = null): Product;
    public function getBySlug(string $slug, ?ProductFilterDTO $dto = null): Product;
    public function delete(Product $product): Product;
    public function toggleActive(Product $product): Product;
    public function exportProducts(?ProductFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
