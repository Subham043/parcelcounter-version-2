<?php

namespace App\Features\PaymentOptions\Repositories;

use App\Features\PaymentOptions\DTO\PaymentOptionFilterDTO;
use App\Features\PaymentOptions\Models\PaymentOption;
use App\Features\PaymentOptions\Interfaces\PaymentOptionRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class PaymentOptionRepository implements PaymentOptionRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'slug',
        'description',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'slug', 
            'description', 
            'image', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }

    public function model(?PaymentOptionFilterDTO $dto = null): Builder
    {
        return PaymentOption::select(...$this->getSelectColumns());
    }

    public function query(?PaymentOptionFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
            ]);
    }

    public function create(array $data): PaymentOption
    {
        return $this->model()->create($data);
    }

    public function update(PaymentOption $option, array $data): PaymentOption
    {
        $option->update($data);
        return $option->refresh();
    }

    public function delete(PaymentOption $option): PaymentOption
    {
        $option->delete();
        return $option;
    }

    public function getById(int $id): PaymentOption
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?PaymentOption
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): PaymentOption
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(?PaymentOptionFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?PaymentOptionFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}