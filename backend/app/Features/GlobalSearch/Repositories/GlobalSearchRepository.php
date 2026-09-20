<?php

namespace App\Features\GlobalSearch\Repositories;

use App\Features\Categories\Models\Category;
use App\Features\GlobalSearch\Interfaces\GlobalSearchRepositoryInterface;
use App\Features\Products\Models\Product;
use App\Features\SubCategories\Models\SubCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Support\Facades\DB;

class GlobalSearchRepository implements GlobalSearchRepositoryInterface
{
    private function categoryQuery(): Builder
    {
        $search = request()->query('filter')['search'] ?? null;
        return Category::query()
        ->select('id', 'name', 'slug', 'image', DB::raw('"CATEGORY" as type'))
        ->where('is_active', true)
        ->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', $search)
                ->orWhere('slug', $search)
                ->orWhere('meta_keywords', $search)
                ->orWhereRaw('MATCH(name, slug, meta_keywords) AGAINST(? IN BOOLEAN MODE)', [$search . '*']);
            });
        });
    }

    private function subCategoryQuery(): Builder
    {
        $search = request()->query('filter')['search'] ?? null;
        return SubCategory::query()
        ->select('id', 'name', 'slug', 'image', DB::raw('"SUBCATEGORY" as type'))
        ->where('is_active', true)
        ->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', $search)
                ->orWhere('slug', $search)
                ->orWhere('meta_keywords', $search)
                ->orWhereRaw('MATCH(name, slug, meta_keywords) AGAINST(? IN BOOLEAN MODE)', [$search . '*']);
            });
        });
    }

    private function productQuery(): Builder
    {
        $search = request()->query('filter')['search'] ?? null;
        return Product::query()
        ->select('id', 'name', 'slug', 'image', DB::raw('"PRODUCT" as type'))
        ->where('is_active', true)
        ->when($search, function (Builder $query) use ($search) {
            $query->where(function (Builder $q) use ($search) {
                $q->where('name', $search)
                ->orWhere('slug', $search)
                ->orWhere('meta_keywords', $search)
                ->orWhereRaw('MATCH(name, slug, meta_keywords) AGAINST(? IN BOOLEAN MODE)', [$search . '*']);
            });
        });
    }
    
    public function model(): Builder
    {
        $query1 = $this->categoryQuery();
        $query2 = $this->subCategoryQuery();
        $query3 = $this->productQuery();
        $query4 = $query3->union($query2);
        $query = $query4->union($query1);

        $queryOrder = 'CASE WHEN `type` = "PRODUCT" THEN 3 WHEN `type` = "SUBCATEGORY" THEN 2 ELSE 1 END';

        return $query->orderByRaw($queryOrder);
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->allowedFields(['id', 'name', 'slug', 'image'])
            ->defaultSort('name')
            ->allowedSorts('id', 'name');
    }

    public function paginate(int $total = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($total)->appends(request()->query());
    }
}
