<?php

namespace App\Features\BillingInformations\Interfaces;

use App\Features\BillingInformations\Models\BillingInformation;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface BillingInformationRepositoryInterface
{
    public function model(int $user_id): Builder;
    public function query(int $user_id): QueryBuilder;
    public function create(int $user_id, array $data): BillingInformation;
    public function update(BillingInformation $enquiry, array $data): BillingInformation;
    public function delete(BillingInformation $enquiry): BillingInformation;
    public function getById(int $user_id, int $id): BillingInformation;
    public function getByColumn(int $user_id, string $column, mixed $value): ?BillingInformation;
    public function getByColumnOrFail(int $user_id, string $column, mixed $value): BillingInformation;
    public function paginate(int $user_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $user_id): Collection;
}
