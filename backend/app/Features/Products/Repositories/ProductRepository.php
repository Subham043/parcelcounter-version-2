<?php

namespace App\Features\Products\Repositories;

use App\Features\Products\Interfaces\ProductRepositoryInterface;
use App\Features\Products\Models\Product;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository implements ProductRepositoryInterface
{
    public function model(bool $withCategory = false): Builder
    {
        return Product::select('id', 'name', 'hsn', 'slug', 'description', 'description_unfiltered', 'brief_description', 'image', 'meta_title', 'meta_description', 'meta_keywords', 'is_active', 'is_new', 'is_on_sale', 'is_featured', 'min_cart_quantity', 'cart_quantity_interval', 'cart_quantity_specification', 'user_id', 'created_at', 'updated_at')
        ->when($withCategory, function ($query) {
            return $query->with('categories:id,name');
        });
    }

    public function query(bool $withCategory = false): QueryBuilder
    {
        return QueryBuilder::for($this->model($withCategory))
            ->defaultSort('-id')
            ->allowedSorts('id', 'name')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
                AllowedFilter::callback('is_active', function (Builder $query, $value) {
                    if (strtolower($value) == 'yes') {
                        $query->where('is_active', true);
                    }
                    if (strtolower($value) == 'no') {
                        $query->where('is_active', false);
                    }
                }),
            ]);
    }

    public function create(array $data): Product
    {
        return $this->model(false)->create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);

        return $product->refresh();
    }

    public function delete(Product $product): Product
    {
        $product->delete();

        return $product;
    }

    public function syncCategories(Product $product, array $data): Product
    {
        $product->categories()->sync($data);

        return $product->load([
            'categories:id,name',
        ]);
    }

    public function getById(int $id, bool $withCategory = false): Product
    {
        return $this->model($withCategory)->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value, bool $withCategory = false): ?Product
    {
        return $this->model($withCategory)->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value, bool $withCategory = false): Product
    {
        return $this->model($withCategory)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $total = 15, bool $withCategory = false): LengthAwarePaginator
    {
        return $this->query($withCategory)->paginate($total)->appends(request()->query());
    }

    public function getAll(bool $withCategory = false): Collection
    {
        return $this->query($withCategory)->lazy(100)->collect();
    }
}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->where(function ($q) use ($value) {
            $q->where('name', $value)
                ->orWhere('slug', $value)
                ->orWhere('hsn', $value)
                ->orWhere('description_unfiltered', $value)
                ->orWhere('brief_description', $value)
                ->orWhere('meta_title', $value)
                ->orWhere('meta_description', $value)
                ->orWhere('meta_keywords', $value)
                ->orWhereRaw('MATCH(name, slug, hsn, description_unfiltered, brief_description, meta_title, meta_description, meta_keywords) AGAINST(? IN BOOLEAN MODE)', [$value.'*']);
        });
    }
}
