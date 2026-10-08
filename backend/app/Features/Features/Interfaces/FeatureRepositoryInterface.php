<?php

namespace App\Features\Features\Interfaces;

use App\Features\Features\DTO\FeatureFilterDTO;
use App\Features\Features\Models\Feature;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface FeatureRepositoryInterface
{
    public function model(?FeatureFilterDTO $dto = null): Builder;
    public function query(?FeatureFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): Feature;
    public function update(Feature $feature, array $data): Feature;
    public function delete(Feature $feature): Feature;
    public function getById(int $id): Feature;
    public function getByColumn(string $column, mixed $value): ?Feature;
    public function getByColumnOrFail(string $column, mixed $value): Feature;
    public function paginate(?FeatureFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?FeatureFilterDTO $dto = null): Collection;
}
