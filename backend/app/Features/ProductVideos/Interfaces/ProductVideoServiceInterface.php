<?php

namespace App\Features\ProductVideos\Interfaces;

use App\Features\ProductVideos\DTO\ProductVideoDTO;
use App\Features\ProductVideos\Models\ProductVideo;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductVideoServiceInterface
{
    public function paginate(int $product_id, int $total = 10): LengthAwarePaginator;
    public function create(ProductVideoDTO $data, int $product_id): ProductVideo;
    public function update(ProductVideoDTO $data, ProductVideo $video): ProductVideo;
    public function getById(int $product_id, int $id): ProductVideo;
    public function delete(ProductVideo $video): ProductVideo;
}
