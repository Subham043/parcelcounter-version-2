<?php

namespace App\Features\Blogs\Repositories;


use App\Features\Blogs\Models\Blog;
use App\Features\Blogs\Interfaces\BlogRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class BlogRepository implements BlogRepositoryInterface
{
    public function model(): Builder
    {
        return Blog::select('id', 'name', 'heading', 'slug', 'description', 'description_unfiltered', 'image', 'meta_title', 'meta_description', 'meta_keywords', 'is_popular', 'is_active', 'user_id', 'created_at', 'updated_at');
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
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
                AllowedFilter::callback('is_popular', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->where('is_popular', true);
                    }
                    if (strtolower($value) == "no") {
                        $query->where('is_popular', false);
                    }
                }),
            ]);
    }

    public function create(array $data): Blog
    {
        return $this->model()->create($data);
    }

    public function update(Blog $blog, array $data): Blog
    {
        $blog->update($data);
        return $blog->refresh();
    }

    public function delete(Blog $blog): Blog
    {
        $blog->delete();
        return $blog;
    }

    public function getById(int $id): Blog
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Blog
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Blog
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(int $total = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($total)->appends(request()->query());
    }

    public function getAll(): Collection
    {
        return $this->query()->lazy(100)->collect();
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
