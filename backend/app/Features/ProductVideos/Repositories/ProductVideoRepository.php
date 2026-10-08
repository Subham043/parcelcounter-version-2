<?php

namespace App\Features\ProductVideos\Repositories;

use App\Features\ProductVideos\DTO\ProductVideoFilterDTO;
use App\Features\ProductVideos\Models\ProductVideo;
use App\Features\ProductVideos\Interfaces\ProductVideoRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProductVideoRepository implements ProductVideoRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'video', 
            'product_id', 
            'created_at', 
            'updated_at'
        ];
    }
    public function model(int $product_id, ?ProductVideoFilterDTO $dto = null): Builder
    {
        return ProductVideo::where('product_id', $product_id)->select(...$this->getSelectColumns());
    }

    public function query(int $product_id, ?ProductVideoFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS);
    }

    public function create(array $data, int $product_id): ProductVideo
    {
        return $this->model($product_id)->create([...$data, 'product_id' => $product_id]);
    }

    public function update(ProductVideo $video, array $data): ProductVideo
    {
        $video->update($data);
        return $video->refresh();
    }

    public function delete(ProductVideo $video): ProductVideo
    {
        $video->delete();
        return $video;
    }

    public function getById(int $product_id, int $id): ProductVideo
    {
        return $this->model($product_id)->findOrFail($id);
    }

    public function getByColumn(int $product_id, string $column, mixed $value): ?ProductVideo
    {
        return $this->model($product_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $product_id, string $column, mixed $value): ProductVideo
    {
        return $this->model($product_id)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $product_id, ?ProductVideoFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($product_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $product_id, ?ProductVideoFilterDTO $dto = null): Collection
    {
        return $this->query($product_id, $dto)->lazy(100)->collect();
    }
}
