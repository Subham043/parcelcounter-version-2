<?php

namespace App\Features\ProductImages\Repositories;


use App\Features\ProductImages\Models\ProductImage;
use App\Features\ProductImages\Interfaces\ProductImageRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class ProductImageRepository implements ProductImageRepositoryInterface
{
    public function model(int $product_id): Builder
    {
        return ProductImage::where('product_id', $product_id)->select('id', 'image_title', 'image_alt', 'image', 'product_id', 'created_at', 'updated_at');
    }

    public function query(int $product_id): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id))
            ->defaultSort('-id')
            ->allowedSorts('id')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
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

    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator
    {
        return $this->query($product_id)->paginate($total)->appends(request()->query());
    }

    public function getAll(int $product_id): Collection
    {
        return $this->query($product_id)->lazy(100)->collect();
    }
}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->where(function ($q) use ($value) {
            $q->where('image_title', $value)
                ->orWhere('image_alt', $value)
                ->orWhereRaw('MATCH(image_title, image_alt) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
