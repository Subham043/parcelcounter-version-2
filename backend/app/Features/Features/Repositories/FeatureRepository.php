<?php

namespace App\Features\Features\Repositories;


use App\Features\Features\Models\Feature;
use App\Features\Features\Interfaces\FeatureRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class FeatureRepository implements FeatureRepositoryInterface
{
    public function model(): Builder
    {
        return Feature::select('id', 'title', 'description', 'image', 'is_active', 'user_id', 'created_at', 'updated_at');
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id', 'title')
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

    public function create(array $data): Feature
    {
        return $this->model()->create($data);
    }

    public function update(Feature $feature, array $data): Feature
    {
        $feature->update($data);
        return $feature->refresh();
    }

    public function delete(Feature $feature): Feature
    {
        $feature->delete();
        return $feature;
    }

    public function getById(int $id): Feature
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Feature
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Feature
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
            $q->where('title', $value)
                ->orWhere('description', $value)
                ->orWhereRaw('MATCH(title, description) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
