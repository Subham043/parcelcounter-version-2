<?php

namespace App\Features\Products\Repositories;

use App\Features\Products\DTO\ProductFilterDTO;
use App\Features\Products\Interfaces\ProductRepositoryInterface;
use App\Features\Products\Models\Product;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\CategoryFilter;
use App\Http\CommonFilters\SubCategoryFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class ProductRepository implements ProductRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'slug',
        'hsn',
        'description_unfiltered',
        'brief_description',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'slug',
        ];
    }

    private function getAllColumns(): array
    {
        return [
            ...$this->getSelectColumns(),
            'hsn',
            'description',
            'description_unfiltered',
            'brief_description',
            'image',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'is_active',
            'is_new', 
            'is_on_sale', 
            'is_featured', 
            'min_cart_quantity', 
            'cart_quantity_interval', 
            'cart_quantity_specification',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    public function model(?ProductFilterDTO $dto = null): Builder
    {
        return Product::query()
        ->when(
            $dto?->is_select !== null,
            fn ($query) => $query->select(
                ...($dto?->is_select === true
                    ? $this->getSelectColumns()
                    : $this->getAllColumns())
            )
        )
        ->when($dto?->include_category==true, function ($query) {
            return $query->with('categories:id,name,slug');
        })
        ->when($dto?->include_sub_category==true, function ($query) {
            return $query->with('sub_categories:id,name,slug');
        })
        ->when($dto?->include_tax==true, function ($query) {
            return $query->with('taxes:id,name,slug,value,is_inter_state_tax');
        })
        ->when($dto?->include_specification==true, function ($query) {
            return $query->with('specifications:id,title,description,product_id');
        })
        ->when($dto?->include_image==true, function ($query) {
            return $query->with('images:id,image,image_title,image_alt,product_id');
        })
        ->when($dto?->include_video==true, function ($query) {
            return $query->with('videos:id,video,product_id');
        })
        ->when($dto?->include_color==true, function ($query) {
            return $query->with('colors:id,name,code,product_id');
        })
        ->when($dto?->include_price==true, function ($query) {
            // return $query->with('prices:id,min_quantity,price,product_id')->orderBy('product_prices.min_quantity', 'asc');
            return $query->with([
                'prices' => function ($query) {
                    $query->select([
                        'product_prices.id',
                        'product_prices.product_id',
                        'product_prices.min_quantity',
                        'product_prices.price'
                    ])->orderBy('product_prices.min_quantity', 'asc');
                },
            ]);
        })
        ->when($dto?->include_stock==true, function ($query) {
            return $query->with('stocks:id,purchase_stock,quantity,remaining_quantity,purchased_at,product_id');
        })
        ->when($dto?->include_latest_stock==true, function ($query) {
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
        ->when($dto?->include_review==true, function ($query) {
            return $query->with('reviews:id,rating,comment,is_active,product_id');
        });
    }

    public function query(?ProductFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::callback('is_active', new BooleanFilter),
                AllowedFilter::callback('is_new', new BooleanFilter),
                AllowedFilter::callback('is_on_sale', new BooleanFilter),
                AllowedFilter::callback('is_featured', new BooleanFilter),
                AllowedFilter::callback('category', new CategoryFilter),
                AllowedFilter::callback('sub_category', new SubCategoryFilter),
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
            ]);
    }

    public function create(array $data): Product
    {
        return $this->model(null)->create($data);
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

    public function saveImages(Product $product, array $data): Product
    {
        $data = collect($data)
            ->map(fn ($image) => [
                'product_id' => $product->id,
                'image' => $image,
            ])
            ->toArray();

        $product->images()->createMany($data);

        return $product->load([
            'images:id,image,image_title,image_alt,product_id',
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

    public function getById(int $id, ?ProductFilterDTO $dto = null): Product
    {
        return $this->model($dto)->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value, ?ProductFilterDTO $dto = null): ?Product
    {
        return $this->model($dto)->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value, ?ProductFilterDTO $dto = null): Product
    {
        return $this->model($dto)->where($column, $value)->firstOrFail();
    }

    public function paginate(?ProductFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate(15)->appends(request()->query());
    }

    public function getAll(?ProductFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}