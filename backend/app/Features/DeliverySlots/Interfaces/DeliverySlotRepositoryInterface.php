<?php

namespace App\Features\DeliverySlots\Interfaces;

use App\Features\DeliverySlots\DTO\DeliverySlotFilterDTO;
use App\Features\DeliverySlots\Models\DeliverySlot;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface DeliverySlotRepositoryInterface
{
    public function model(?DeliverySlotFilterDTO $dto = null): Builder;
    public function query(?DeliverySlotFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): DeliverySlot;
    public function update(DeliverySlot $slot, array $data): DeliverySlot;
    public function delete(DeliverySlot $slot): DeliverySlot;
    public function getById(int $id): DeliverySlot;
    public function getByColumn(string $column, mixed $value): ?DeliverySlot;
    public function getByColumnOrFail(string $column, mixed $value): DeliverySlot;
    public function paginate(?DeliverySlotFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?DeliverySlotFilterDTO $dto = null): Collection;
}
