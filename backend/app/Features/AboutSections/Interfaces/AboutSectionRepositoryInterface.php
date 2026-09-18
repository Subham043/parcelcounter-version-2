<?php

namespace App\Features\AboutSections\Interfaces;

use App\Features\AboutSections\Models\AboutSection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface AboutSectionRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): AboutSection;
    public function update(AboutSection $section, array $data): AboutSection;
    public function delete(AboutSection $section): AboutSection;
    public function getById(int $id): AboutSection;
    public function getByColumn(string $column, mixed $value): ?AboutSection;
    public function getByColumnOrFail(string $column, mixed $value): AboutSection;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
