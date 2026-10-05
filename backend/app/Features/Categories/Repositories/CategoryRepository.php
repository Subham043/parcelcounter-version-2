<?php

namespace App\Features\Categories\Repositories;


use App\Features\Categories\Models\Category;
use App\Features\Categories\Interfaces\CategoryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class CategoryRepository implements CategoryRepositoryInterface
{
    public function model(bool $isSelect = false): Builder
    {
        return Category::when($isSelect==true, function ($query) {
            return $query->select('id', 'name', 'slug');
        })
        ->when($isSelect==false, function ($query) {
            return $query->select('id', 'name', 'heading', 'slug', 'description', 'description_unfiltered', 'image', 'meta_title', 'meta_description', 'meta_keywords', 'is_active', 'user_id', 'created_at', 'updated_at');
        });
    }

    public function query(bool $isSelect = false): QueryBuilder
    {
        return QueryBuilder::for($this->model($isSelect))
            ->defaultSort('-id')
            ->allowedSorts('id', 'name')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
                AllowedFilter::callback('is_active', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->where('is_active', true);
                    }
                    if (strtolower($value) == "no") {
                        $query->where('is_active', false);
                    }
                }),
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

    public function paginate(int $total = 15, bool $isSelect = false): LengthAwarePaginator
    {
        return $this->query($isSelect)->paginate($total)->appends(request()->query());
    }

    public function getAll(bool $isSelect = false): Collection
    {
        return $this->query($isSelect)->lazy(100)->collect();
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
                ->orWhereRaw('MATCH(name, slug, heading, description_unfiltered, meta_title, meta_description, meta_keywords) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
