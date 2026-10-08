<?php

namespace App\Features\LegalContents\Interfaces;

use App\Features\LegalContents\DTO\LegalContentFilterDTO;
use App\Features\LegalContents\Models\LegalContent;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface LegalContentRepositoryInterface
{
    public function model(?LegalContentFilterDTO $dto = null): Builder;
    public function query(?LegalContentFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): LegalContent;
    public function update(LegalContent $legalContent, array $data): LegalContent;
    public function delete(LegalContent $legalContent): LegalContent;
    public function getById(int $id): LegalContent;
    public function getByColumn(string $column, mixed $value): ?LegalContent;
    public function getByColumnOrFail(string $column, mixed $value): LegalContent;
    public function paginate(?LegalContentFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?LegalContentFilterDTO $dto = null): Collection;
}
