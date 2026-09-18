<?php

namespace App\Features\Banners\Interfaces;

use App\Features\Banners\Models\Banner;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface BannerRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): Banner;
    public function update(Banner $banner, array $data): Banner;
    public function delete(Banner $banner): Banner;
    public function getById(int $id): Banner;
    public function getByColumn(string $column, mixed $value): ?Banner;
    public function getByColumnOrFail(string $column, mixed $value): Banner;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
