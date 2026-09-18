<?php

namespace App\Features\ProductVideos\Interfaces;

use App\Features\ProductVideos\Models\ProductVideo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ProductVideoRepositoryInterface
{
    public function model(int $product_id): Builder;
    public function query(int $product_id): QueryBuilder;
    public function create(array $data, int $product_id): ProductVideo;
    public function update(ProductVideo $video, array $data): ProductVideo;
    public function delete(ProductVideo $video): ProductVideo;
    public function getById(int $product_id, int $id): ProductVideo;
    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductVideo;
    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductVideo;
    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator;
    public function getAll(int $product_id): Collection;
}
