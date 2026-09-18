<?php

namespace App\Features\ProductVideos\Repositories;


use App\Features\ProductVideos\Models\ProductVideo;
use App\Features\ProductVideos\Interfaces\ProductVideoRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

class ProductVideoRepository implements ProductVideoRepositoryInterface
{
    public function model(int $product_id): Builder
    {
        return ProductVideo::where('product_id', $product_id)->select('id', 'video', 'product_id', 'created_at', 'updated_at');
    }

    public function query(int $product_id): QueryBuilder
    {
        return QueryBuilder::for($this->model($product_id))
            ->defaultSort('-id')
            ->allowedSorts('id');
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

    public function paginate(int $product_id, int $total = 15): LengthAwarePaginator
    {
        return $this->query($product_id)->paginate($total)->appends(request()->query());
    }

    public function getAll(int $product_id): Collection
    {
        return $this->query($product_id)->lazy(100)->collect();
    }
}
