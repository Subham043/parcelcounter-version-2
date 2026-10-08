<?php

namespace App\Features\Taxes\Repositories;

use App\Features\Taxes\DTO\TaxFilterDTO;
use App\Features\Taxes\Models\Tax;
use App\Features\Taxes\Interfaces\TaxRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class TaxRepository implements TaxRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'slug',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'slug', 'value', 'is_inter_state_tax', 'is_active', 'user_id', 'created_at', 'updated_at'
        ];
    }

    public function model(?TaxFilterDTO $dto = null): Builder
    {
        return Tax::select(...$this->getSelectColumns());
    }

    public function query(?TaxFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
                AllowedFilter::callback('is_inter_state_tax', new BooleanFilter),
            ]);
    }

    public function create(array $data): Tax
    {
        return $this->model()->create($data);
    }

    public function update(Tax $tax, array $data): Tax
    {
        $tax->update($data);
        return $tax->refresh();
    }

    public function delete(Tax $tax): Tax
    {
        $tax->delete();
        return $tax;
    }

    public function getById(int $id): Tax
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Tax
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Tax
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(?TaxFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?TaxFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
