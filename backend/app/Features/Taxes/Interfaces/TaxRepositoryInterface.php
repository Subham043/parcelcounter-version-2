<?php

namespace App\Features\Taxes\Interfaces;

use App\Features\Taxes\Models\Tax;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface TaxRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): Tax;
    public function update(Tax $tax, array $data): Tax;
    public function delete(Tax $tax): Tax;
    public function getById(int $id): Tax;
    public function getByColumn(string $column, mixed $value): ?Tax;
    public function getByColumnOrFail(string $column, mixed $value): Tax;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
