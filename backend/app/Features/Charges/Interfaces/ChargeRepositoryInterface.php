<?php

namespace App\Features\Charges\Interfaces;

use App\Features\Charges\DTO\ChargeFilterDTO;
use App\Features\Charges\Models\Charge;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ChargeRepositoryInterface
{
    public function model(?ChargeFilterDTO $dto = null): Builder;
    public function query(?ChargeFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): Charge;
    public function update(Charge $charge, array $data): Charge;
    public function delete(Charge $charge): Charge;
    public function getById(int $id): Charge;
    public function getByColumn(string $column, mixed $value): ?Charge;
    public function getByColumnOrFail(string $column, mixed $value): Charge;
    public function paginate(?ChargeFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?ChargeFilterDTO $dto = null): Collection;
}
