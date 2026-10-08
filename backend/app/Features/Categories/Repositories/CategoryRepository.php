<?php

namespace App\Features\Categories\Repositories;

use App\Features\Categories\DTO\CategoryFilterDTO;
use App\Features\Categories\Models\Category;
use App\Features\Categories\Interfaces\CategoryRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class CategoryRepository implements CategoryRepositoryInterface
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
    
    public function model(?CategoryFilterDTO $dto = null): Builder
    {
        return Category::query()
        ->when(
            $dto?->is_select !== null,
            fn ($query) => $query->select(
                ...($dto?->is_select === true
                    ? $this->getSelectColumns()
                    : $this->getAllColumns())
            )
        );
    }

    public function query(?CategoryFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
            ]);
    }

    public function create(array $data): Category
    {
        return $this->model()->create($data);
    }

    public function update(Category $category, array $data): Category
    {
        $category->update($data);
        return $category->refresh();
    }

    public function delete(Category $category): Category
    {
        $category->delete();
        return $category;
    }

    public function getById(int $id): Category
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Category
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Category
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(?CategoryFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?CategoryFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
