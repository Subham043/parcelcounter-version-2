<?php

namespace App\Features\Certifications\Interfaces;

use App\Features\Certifications\DTO\CertificationFilterDTO;
use App\Features\Certifications\Models\Certification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface CertificationRepositoryInterface
{
    public function model(?CertificationFilterDTO $dto = null): Builder;
    public function query(?CertificationFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): Certification;
    public function update(Certification $certification, array $data): Certification;
    public function delete(Certification $certification): Certification;
    public function getById(int $id): Certification;
    public function getByColumn(string $column, mixed $value): ?Certification;
    public function getByColumnOrFail(string $column, mixed $value): Certification;
    public function paginate(?CertificationFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?CertificationFilterDTO $dto = null): Collection;
}
