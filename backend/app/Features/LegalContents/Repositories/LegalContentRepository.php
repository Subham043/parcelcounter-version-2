<?php

namespace App\Features\LegalContents\Repositories;


use App\Features\LegalContents\Models\LegalContent;
use App\Features\LegalContents\Interfaces\LegalContentRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class LegalContentRepository implements LegalContentRepositoryInterface
{
    public function model(): Builder
    {
        return LegalContent::select('id', 'name', 'heading', 'slug', 'description', 'description_unfiltered', 'meta_title', 'meta_description', 'meta_keywords', 'is_active', 'user_id', 'created_at', 'updated_at');
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
            ]);
    }

    public function create(array $data): LegalContent
    {
        return $this->model()->create($data);
    }

    public function update(LegalContent $legalContent, array $data): LegalContent
    {
        $legalContent->update($data);
        return $legalContent->refresh();
    }

    public function delete(LegalContent $legalContent): LegalContent
    {
        $legalContent->delete();
        return $legalContent;
    }

    public function getById(int $id): LegalContent
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?LegalContent
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): LegalContent
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
