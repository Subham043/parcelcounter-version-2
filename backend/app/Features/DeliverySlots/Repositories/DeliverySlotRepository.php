<?php

namespace App\Features\DeliverySlots\Repositories;

use App\Features\DeliverySlots\DTO\DeliverySlotFilterDTO;
use App\Features\DeliverySlots\Models\DeliverySlot;
use App\Features\DeliverySlots\Interfaces\DeliverySlotRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class DeliverySlotRepository implements DeliverySlotRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'start_time',
    ];

    private const SEARCH_COLUMNS = [
        'name',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            ...self::SEARCH_COLUMNS,
            'end_time', 
            'is_cod_allowed', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }

    public function model(?DeliverySlotFilterDTO $dto = null): Builder
    {
        return DeliverySlot::select(...$this->getSelectColumns());
    }

    public function query(?DeliverySlotFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
                AllowedFilter::callback('is_cod_allowed', new BooleanFilter),
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

    public function paginate(?DeliverySlotFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?DeliverySlotFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
