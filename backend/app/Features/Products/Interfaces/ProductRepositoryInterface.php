<?php

namespace App\Features\Products\Interfaces;

use App\Features\Products\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductRepositoryInterface
{
    public function model(bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Builder;
    public function query(bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): QueryBuilder;
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
    public function delete(Product $product): Product;
    public function getById(int $id, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Product;
    public function getByColumn(string $column, mixed $value, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): ?Product;
    public function getByColumnOrFail(string $column, mixed $value, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Product;
    public function paginate(int $total = 15, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): LengthAwarePaginator;
    public function getAll(bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Collection;
}
