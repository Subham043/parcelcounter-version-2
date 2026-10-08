<?php

namespace App\Features\Blogs\Repositories;

use App\Features\Blogs\DTO\BlogFilterDTO;
use App\Features\Blogs\Models\Blog;
use App\Features\Blogs\Interfaces\BlogRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class BlogRepository implements BlogRepositoryInterface
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
            'heading', 
            'slug', 
            'description', 
            'description_unfiltered', 
            'image', 
            'meta_title', 
            'meta_description', 
            'meta_keywords', 
            'is_popular', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }

    public function model(?BlogFilterDTO $dto = null): Builder
    {
        return Blog::select(...$this->getSelectColumns());
    }

    public function query(?BlogFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
                AllowedFilter::callback('is_popular', new BooleanFilter),
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

    public function paginate(?BlogFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?BlogFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
