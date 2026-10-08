<?php

namespace App\Features\PaymentOptions\Interfaces;

use App\Features\PaymentOptions\DTO\PaymentOptionFilterDTO;
use App\Features\PaymentOptions\Models\PaymentOption;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface PaymentOptionRepositoryInterface
{
    public function model(?PaymentOptionFilterDTO $dto = null): Builder;
    public function query(?PaymentOptionFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): PaymentOption;
    public function update(PaymentOption $option, array $data): PaymentOption;
    public function delete(PaymentOption $option): PaymentOption;
    public function getById(int $id): PaymentOption;
    public function getByColumn(string $column, mixed $value): ?PaymentOption;
    public function getByColumnOrFail(string $column, mixed $value): PaymentOption;
    public function paginate(?PaymentOptionFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?PaymentOptionFilterDTO $dto = null): Collection;
}
