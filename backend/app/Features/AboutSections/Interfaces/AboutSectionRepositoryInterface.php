<?php

namespace App\Features\AboutSections\Interfaces;

use App\Features\AboutSections\DTO\AboutSectionFilterDTO;
use App\Features\AboutSections\Models\AboutSection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface AboutSectionRepositoryInterface
{
    public function model(?AboutSectionFilterDTO $dto = null): Builder;
    public function query(?AboutSectionFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): AboutSection;
    public function update(AboutSection $section, array $data): AboutSection;
    public function delete(AboutSection $section): AboutSection;
    public function getById(int $id): AboutSection;
    public function getByColumn(string $column, mixed $value): ?AboutSection;
    public function getByColumnOrFail(string $column, mixed $value): AboutSection;
    public function paginate(?AboutSectionFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?AboutSectionFilterDTO $dto = null): Collection;
}
