<?php

namespace App\Features\ProductImages\Repositories;

use App\Features\ProductImages\DTO\ProductImageFilterDTO;
use App\Features\ProductImages\Models\ProductImage;
use App\Features\ProductImages\Interfaces\ProductImageRepositoryInterface;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
    ];

    private const SEARCH_COLUMNS = [
        'image_title', 'image_alt'
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            ...self::SEARCH_COLUMNS,
            'image', 'product_id', 'created_at', 'updated_at'
        ];
    }
    public function model(int $product_id, ?ProductImageFilterDTO $dto = null): Builder
    {
        return ProductImage::where('product_id', $product_id)->select(...$this->getSelectColumns());
    }

    public function query(int $product_id, ?ProductImageFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
            ]);
    }

    public function create(array $data, int $product_id): ProductImage
    {
        return $this->model($product_id)->create([...$data, 'product_id' => $product_id]);
    }

    public function update(ProductImage $image, array $data): ProductImage
    {
        $image->update($data);
        return $image->refresh();
    }

    public function delete(ProductImage $image): ProductImage
    {
        $image->delete();
        return $image;
    }

    public function getById(int $product_id, int $id): ProductImage
    {
        return $this->model($product_id)->findOrFail($id);
    }

    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductImage
    {
        return $this->model($product_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductImage
    {
        return $this->model($product_id)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $product_id, ?ProductImageFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($product_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $product_id, ?ProductImageFilterDTO $dto = null): Collection
    {
        return $this->query($product_id, $dto)->lazy(100)->collect();
    }
}