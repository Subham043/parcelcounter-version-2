<?php

namespace App\Features\GlobalSearch\Repositories;

use App\Features\Categories\Models\Category;
use App\Features\GlobalSearch\DTO\GlobalSearchFilterDTO;
use App\Features\GlobalSearch\Interfaces\GlobalSearchRepositoryInterface;
use App\Features\Products\Models\Product;
use App\Features\SubCategories\Models\SubCategory;
use Illuminate\Pagination\LengthAwarePaginator;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class GlobalSearchRepository implements GlobalSearchRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'slug',
        'meta_keywords',
    ];

    private const BASE_SELECT_COLUMNS = [
        ...self::SORT_COLUMNS,
        'slug',
        'image',
    ];

    private function getSelectColumns(string $type): array
    {
        return [
            ...self::BASE_SELECT_COLUMNS,
            DB::raw('"' . $type . '" as type')
        ];
    }

    private function searchFilter(
        Builder $query,
        mixed $value,
    ): void {
        $query->where(function (Builder $q) use ($value) {
            $q->where(function (Builder $q) use ($value) {
                foreach (self::SEARCH_COLUMNS as $column) {
                    $q->orWhere($column, $value);
                }
            });
            $search = preg_replace('/[+\-<>()~*"@]/', ' ', $value);
            $search = trim($search);

            if ($search !== '') {
                $q->orWhereRaw(
                    sprintf(
                    'MATCH(%s) AGAINST(? IN BOOLEAN MODE)',
                    implode(', ', self::SEARCH_COLUMNS)
                ),
                    [$search . '*']
                );
            }
        });
    }

    private function globalSearchQuery(
        Builder $query,
        string $table,
        ?string $search = null,
    ): Builder {
        return $query
            ->select(...$this->getSelectColumns($table))
            ->where('is_active', true)
            ->when(
                $search,
                fn (Builder $query) => $this->searchFilter($query, $search)
            );
    }

    private function categoryQuery(?GlobalSearchFilterDTO $dto = null): Builder
    {
        return $this->globalSearchQuery(
            Category::query(),
            'CATEGORY',
            $dto?->search
        );
    }

    private function subCategoryQuery(?GlobalSearchFilterDTO $dto = null): Builder
    {
        return $this->globalSearchQuery(
            SubCategory::query(),
            'SUBCATEGORY',
            $dto?->search
        );
    }

    private function productQuery(?GlobalSearchFilterDTO $dto = null): Builder
    {
        return $this->globalSearchQuery(
            Product::query(),
            'PRODUCT',
            $dto?->search
        );
    }
    
    public function model(?GlobalSearchFilterDTO $dto = null): Builder
    {
        $query1 = $this->categoryQuery($dto);
        $query2 = $this->subCategoryQuery($dto);
        $query3 = $this->productQuery($dto);
        $query4 = $query3->union($query2);
        $query = $query4->union($query1);

        $queryOrder = 'CASE WHEN `type` = "PRODUCT" THEN 3 WHEN `type` = "SUBCATEGORY" THEN 2 ELSE 1 END';

        return $query->orderByRaw($queryOrder);
    }

    public function query(?GlobalSearchFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->allowedFields([...self::BASE_SELECT_COLUMNS])
            ->defaultSort($dto?->sort ?? 'name')
            ->allowedSorts(...self::SORT_COLUMNS);
    }

    public function paginate(?GlobalSearchFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }
}
