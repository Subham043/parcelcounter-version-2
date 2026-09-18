<?php

namespace App\Features\DeliverySlots\Repositories;


use App\Features\DeliverySlots\Models\DeliverySlot;
use App\Features\DeliverySlots\Interfaces\DeliverySlotRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class DeliverySlotRepository implements DeliverySlotRepositoryInterface
{
    public function model(): Builder
    {
        return DeliverySlot::select('id', 'name', 'start_time', 'end_time', 'is_cod_allowed', 'is_active', 'user_id', 'created_at', 'updated_at');
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id', 'start_time')
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
                AllowedFilter::callback('is_cod_allowed', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->where('is_cod_allowed', true);
                    }
                    if (strtolower($value) == "no") {
                        $query->where('is_cod_allowed', false);
                    }
                }),
            ]);
    }

    public function create(array $data): DeliverySlot
    {
        return $this->model()->create($data);
    }

    public function update(DeliverySlot $slot, array $data): DeliverySlot
    {
        $slot->update($data);
        return $slot->refresh();
    }

    public function delete(DeliverySlot $slot): DeliverySlot
    {
        $slot->delete();
        return $slot;
    }

    public function getById(int $id): DeliverySlot
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?DeliverySlot
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): DeliverySlot
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
                ->orWhereRaw('MATCH(name) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
