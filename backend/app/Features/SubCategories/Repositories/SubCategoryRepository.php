<?php

namespace App\Features\SubCategories\Repositories;

use App\Features\SubCategories\Interfaces\SubCategoryRepositoryInterface;
use App\Features\SubCategories\Models\SubCategory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;
use Spatie\QueryBuilder\QueryBuilder;

class SubCategoryRepository implements SubCategoryRepositoryInterface
{
    public function model(bool $withCategory = false): Builder
    {
        return SubCategory::select('id', 'name', 'heading', 'slug', 'description', 'description_unfiltered', 'image', 'meta_title', 'meta_description', 'meta_keywords', 'is_active', 'user_id', 'created_at', 'updated_at')
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

    public function create(array $data): SubCategory
    {
        return $this->model(false)->create($data);
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

    public function getById(int $id, bool $withCategory = false): SubCategory
    {
        return $this->model($withCategory)->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value, bool $withCategory = false): ?SubCategory
    {
        return $this->model($withCategory)->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value, bool $withCategory = false): SubCategory
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
                ->orWhere('heading', $value)
                ->orWhere('description_unfiltered', $value)
                ->orWhere('meta_title', $value)
                ->orWhere('meta_description', $value)
                ->orWhere('meta_keywords', $value)
                ->orWhereRaw('MATCH(name, slug, heading, description_unfiltered, meta_title, meta_description, meta_keywords) AGAINST(? IN BOOLEAN MODE)', [$value.'*']);
        });
    }
}
