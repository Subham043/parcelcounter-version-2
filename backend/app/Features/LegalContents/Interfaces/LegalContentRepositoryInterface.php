<?php

namespace App\Features\LegalContents\Interfaces;

use App\Features\LegalContents\Models\LegalContent;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface LegalContentRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): LegalContent;
    public function update(LegalContent $legalContent, array $data): LegalContent;
    public function delete(LegalContent $legalContent): LegalContent;
    public function getById(int $id): LegalContent;
    public function getByColumn(string $column, mixed $value): ?LegalContent;
    public function getByColumnOrFail(string $column, mixed $value): LegalContent;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
