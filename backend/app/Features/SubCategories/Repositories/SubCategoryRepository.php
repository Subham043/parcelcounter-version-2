<?php

namespace App\Features\SubCategories\Repositories;

use App\Features\SubCategories\DTO\SubCategoryFilterDTO;
use App\Features\SubCategories\Interfaces\SubCategoryRepositoryInterface;
use App\Features\SubCategories\Models\SubCategory;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\CategoryFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class SubCategoryRepository implements SubCategoryRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'slug',
        'heading',
        'description_unfiltered',
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
            'heading',
            'description',
            'description_unfiltered',
            'image',
            'meta_title',
            'meta_description',
            'meta_keywords',
            'is_active',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    public function model(?SubCategoryFilterDTO $dto = null): Builder
    {
        return SubCategory::query()
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
        });
    }

    public function query(?SubCategoryFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
                AllowedFilter::callback('category', new CategoryFilter),
            ]);
    }

    public function create(array $data): SubCategory
    {
        return $this->model()->create($data);
    }

    public function update(SubCategory $subCategory, array $data): SubCategory
    {
        $subCategory->update($data);

        return $subCategory->refresh();
    }

    public function delete(SubCategory $subCategory): SubCategory
    {
        $subCategory->delete();

        return $subCategory;
    }

    public function syncCategories(SubCategory $subCategory, array $data): SubCategory
    {
        $subCategory->categories()->sync($data);

        return $subCategory->load([
            'categories:id,name',
        ]);
    }

    public function getById(int $id, ?SubCategoryFilterDTO $dto = null): SubCategory
    {
        return $this->model($dto)->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value, ?SubCategoryFilterDTO $dto = null): ?SubCategory
    {
        return $this->model($dto)->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value, ?SubCategoryFilterDTO $dto = null): SubCategory
    {
        return $this->model($dto)->where($column, $value)->firstOrFail();
    }

    public function paginate(?SubCategoryFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?SubCategoryFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}