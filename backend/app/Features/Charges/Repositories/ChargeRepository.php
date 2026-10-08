<?php

namespace App\Features\Charges\Repositories;

use App\Features\Charges\DTO\ChargeFilterDTO;
use App\Features\Charges\Models\Charge;
use App\Features\Charges\Interfaces\ChargeRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ChargeRepository implements ChargeRepositoryInterface
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
            'slug',
            'value', 
            'is_percentage', 
            'include_charges_for_cart_price_below', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }

    public function model(?ChargeFilterDTO $dto = null): Builder
    {
        return Charge::select(...$this->getSelectColumns());
    }

    public function query(?ChargeFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
                AllowedFilter::callback('is_percentage', new BooleanFilter),
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

    public function paginate(?ChargeFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?ChargeFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
