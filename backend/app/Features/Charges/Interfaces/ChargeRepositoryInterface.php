<?php

namespace App\Features\Charges\Interfaces;

use App\Features\Charges\Models\Charge;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ChargeRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): Charge;
    public function update(Charge $charge, array $data): Charge;
    public function delete(Charge $charge): Charge;
    public function getById(int $id): Charge;
    public function getByColumn(string $column, mixed $value): ?Charge;
    public function getByColumnOrFail(string $column, mixed $value): Charge;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
