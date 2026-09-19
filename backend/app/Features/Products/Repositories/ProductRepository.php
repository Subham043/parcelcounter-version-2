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
    public function model(bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Builder
    {
        return Product::select('id', 'name', 'hsn', 'slug', 'description', 'description_unfiltered', 'brief_description', 'image', 'meta_title', 'meta_description', 'meta_keywords', 'is_active', 'is_new', 'is_on_sale', 'is_featured', 'min_cart_quantity', 'cart_quantity_interval', 'cart_quantity_specification', 'user_id', 'created_at', 'updated_at')
        ->when($withCategory, function ($query) {
            return $query->with('categories:id,name');
        })
        ->when($withSubCategory, function ($query) {
            return $query->with('sub_categories:id,name');
        })
        ->when($withTax, function ($query) {
            return $query->with('taxes:id,name,slug,value,is_inter_state_tax');
        })
        ->when($withSpecification, function ($query) {
            return $query->with('specifications:id,title,description,product_id');
        })
        ->when($withImage, function ($query) {
            return $query->with('images:id,image,image_title,image_alt,product_id');
        })
        ->when($withVideo, function ($query) {
            return $query->with('videos:id,video,product_id');
        })
        ->when($withColors, function ($query) {
            return $query->with('colors:id,name,code,product_id');
        })
        ->when($withPrice, function ($query) {
            return $query->with('prices:id,min_quantity,price,product_id');
        })
        ->when($withStock, function ($query) {
            return $query->with('stocks:id,purchase_stock,quantity,remaining_quantity,purchased_at,product_id');
        })
        ->when($withLatestStock, function ($query) {
            return $query->with([
                'latest_stock' => function ($query) {
                    $query->select([
                        'product_stocks.id',
                        'product_stocks.product_id',
                        'product_stocks.purchase_stock',
                        'product_stocks.quantity',
                        'product_stocks.remaining_quantity',
                        'product_stocks.purchased_at',
                    ]);
                },
            ]);
        })
        ->when($withReview, function ($query) {
            return $query->with('reviews:id,rating,comment,is_active,product_id');
        });
    }

    public function query(bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): QueryBuilder
    {
        return QueryBuilder::for($this->model($withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview))
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

    public function syncSubCategories(Product $product, array $data): Product
    {
        $product->sub_categories()->sync($data);

        return $product->load([
            'sub_categories:id,name',
        ]);
    }

    public function syncTaxes(Product $product, array $data): Product
    {
        $product->taxes()->sync($data);

        return $product->load([
            'taxes:id,name,slug,value,is_inter_state_tax',
        ]);
    }

    public function saveSpecifications(Product $product, array $data): Product
    {
        $data = collect($data)
            ->map(fn ($item) => [
                'id' => $item['id'] ?? null,
                'product_id' => $product->id,
                'title' => $item['title'],
                'description' => $item['description'],
            ])
            ->toArray();

        $product->specifications()->upsert(
            $data,
            ['id', 'product_id'],
            ['title', 'description']
        );

        return $product->load([
            'specifications:id,title,description,product_id',
        ]);
    }

    public function savePrices(Product $product, array $data): Product
    {
        $data = collect($data)
            ->map(fn ($item) => [
                'id' => $item['id'] ?? null,
                'product_id' => $product->id,
                'min_quantity' => $item['min_quantity'],
                'price' => $item['price'],
            ])
            ->toArray();

        $product->prices()->upsert(
            $data,
            ['id', 'product_id'],
            ['min_quantity', 'price']
        );

        return $product->load([
            'prices:id,min_quantity,price,product_id',
        ]);
    }

    public function saveStocks(Product $product, array $data): Product
    {
        $data = collect($data)
            ->map(fn ($item) => [
                'id' => $item['id'] ?? null,
                'product_id' => $product->id,
                'purchase_stock' => $item['purchase_stock'],
                'quantity' => $item['quantity'],
                'remaining_quantity' => $item['quantity'],
                'purchased_at' => $item['purchased_at'],
            ])
            ->toArray();

        $product->stocks()->upsert(
            $data,
            ['id', 'product_id'],
            ['purchase_stock', 'quantity', 'remaining_quantity', 'purchased_at']
        );

        return $product->load([
            'stocks:id,purchase_stock,quantity,remaining_quantity,purchased_at,product_id',
        ]);
    }

    public function saveColors(Product $product, array $data): Product
    {
        $data = collect($data)
            ->map(fn ($item) => [
                'id' => $item['id'] ?? null,
                'product_id' => $product->id,
                'name' => $item['name'],
                'code' => $item['code'],
            ])
            ->toArray();

        $product->colors()->upsert(
            $data,
            ['id', 'product_id'],
            ['name', 'code']
        );

        return $product->load([
            'colors:id,name,code,product_id',
        ]);
    }

    public function saveVideos(Product $product, array $data): Product
    {
        $data = collect($data)
            ->map(fn ($item) => [
                'id' => $item['id'] ?? null,
                'product_id' => $product->id,
                'video' => $item['video'],
            ])
            ->toArray();

        $product->videos()->upsert(
            $data,
            ['id', 'product_id'],
            ['video']
        );

        return $product->load([
            'videos:id,video,product_id',
        ]);
    }

    public function getById(int $id, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Product
    {
        return $this->model($withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview)->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): ?Product
    {
        return $this->model($withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview)->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Product
    {
        return $this->model($withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $total = 15, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): LengthAwarePaginator
    {
        return $this->query($withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview)->paginate($total)->appends(request()->query());
    }

    public function getAll(bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Collection
    {
        return $this->query($withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview)->lazy(100)->collect();
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
