<?php

namespace App\Features\Features\Repositories;

use App\Features\Features\DTO\FeatureFilterDTO;
use App\Features\Features\Models\Feature;
use App\Features\Features\Interfaces\FeatureRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class FeatureRepository implements FeatureRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'title',
    ];

    private const SEARCH_COLUMNS = [
        'title',
        'description',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'description', 
            'image', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }

    public function model(?FeatureFilterDTO $dto = null): Builder
    {
        return Feature::select(...$this->getSelectColumns());
    }

    public function query(?FeatureFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
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

    public function paginate(?FeatureFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?FeatureFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
