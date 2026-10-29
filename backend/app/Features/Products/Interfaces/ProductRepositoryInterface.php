<?php

namespace App\Features\Products\Interfaces;

use App\Features\Products\DTO\ProductFilterDTO;
use App\Features\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductRepositoryInterface
{
    public function model(?ProductFilterDTO $dto = null): Builder;
    public function query(?ProductFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): Product;
    public function update(Product $product, array $data): Product;
    public function syncCategories(Product $product, array $data): Product;
    public function syncSubCategories(Product $product, array $data): Product;
    public function syncTaxes(Product $product, array $data): Product;
    public function saveSpecifications(Product $product, array $data): Product;
    public function savePrices(Product $product, array $data): Product;
    public function saveStocks(Product $product, array $data): Product;
    public function saveColors(Product $product, array $data): Product;
    public function saveVideos(Product $product, array $data): Product;
    public function saveImages(Product $product, array $data): Product;
    public function delete(Product $product): Product;
    public function getById(int $id, ?ProductFilterDTO $dto = null): Product;
    public function getByColumn(string $column, mixed $value, ?ProductFilterDTO $dto = null): ?Product;
    public function getByColumnOrFail(string $column, mixed $value, ?ProductFilterDTO $dto = null): Product;
    public function paginate(?ProductFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?ProductFilterDTO $dto = null): Collection;
}
