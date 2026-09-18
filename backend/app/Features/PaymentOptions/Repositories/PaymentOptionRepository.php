<?php

namespace App\Features\PaymentOptions\Repositories;


use App\Features\PaymentOptions\Models\PaymentOption;
use App\Features\PaymentOptions\Interfaces\PaymentOptionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class PaymentOptionRepository implements PaymentOptionRepositoryInterface
{
    public function model(): Builder
    {
        return PaymentOption::select('id', 'name', 'slug', 'description', 'image', 'is_active', 'user_id', 'created_at', 'updated_at');
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
                ->orWhere('description', $value)
                ->orWhereRaw('MATCH(name, slug, description) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
