<?php

namespace App\Features\Charges\Repositories;


use App\Features\Charges\Models\Charge;
use App\Features\Charges\Interfaces\ChargeRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class ChargeRepository implements ChargeRepositoryInterface
{
    public function model(): Builder
    {
        return Charge::select('id', 'name', 'slug', 'value', 'is_percentage', 'include_charges_for_cart_price_below', 'is_active', 'user_id', 'created_at', 'updated_at');
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
                AllowedFilter::callback('is_percentage', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->where('is_percentage', true);
                    }
                    if (strtolower($value) == "no") {
                        $query->where('is_percentage', false);
                    }
                }),
            ]);
    }

    public function create(array $data): Charge
    {
        return $this->model()->create($data);
    }

    public function update(Charge $charge, array $data): Charge
    {
        $charge->update($data);
        return $charge->refresh();
    }

    public function delete(Charge $charge): Charge
    {
        $charge->delete();
        return $charge;
    }

    public function getById(int $id): Charge
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Charge
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Charge
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
