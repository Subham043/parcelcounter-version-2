<?php

namespace App\Features\PaymentOptions\Interfaces;

use App\Features\PaymentOptions\Models\PaymentOption;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface PaymentOptionRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): PaymentOption;
    public function update(PaymentOption $option, array $data): PaymentOption;
    public function delete(PaymentOption $option): PaymentOption;
    public function getById(int $id): PaymentOption;
    public function getByColumn(string $column, mixed $value): ?PaymentOption;
    public function getByColumnOrFail(string $column, mixed $value): PaymentOption;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
