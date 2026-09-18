<?php

namespace App\Features\Taxes\Repositories;


use App\Features\Taxes\Models\Tax;
use App\Features\Taxes\Interfaces\TaxRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class TaxRepository implements TaxRepositoryInterface
{
    public function model(): Builder
    {
        return Tax::select('id', 'name', 'slug', 'value', 'is_inter_state_tax', 'is_active', 'user_id', 'created_at', 'updated_at');
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
                AllowedFilter::callback('is_inter_state_tax', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->where('is_inter_state_tax', true);
                    }
                    if (strtolower($value) == "no") {
                        $query->where('is_inter_state_tax', false);
                    }
                }),
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
                ->orWhereRaw('MATCH(name, slug) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
