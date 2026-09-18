<?php

namespace App\Features\ProductVideos\Services;

use App\Features\ProductVideos\DTO\ProductVideoDTO;
use App\Features\ProductVideos\Interfaces\ProductVideoRepositoryInterface;
use App\Features\ProductVideos\Interfaces\ProductVideoServiceInterface;
use App\Features\ProductVideos\Models\ProductVideo;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductVideoService implements ProductVideoServiceInterface
{

	public function __construct(private ProductVideoRepositoryInterface $videoRepository) {}

	public function paginate(int $product_id, int $total = 10): LengthAwarePaginator
	{
		return $this->videoRepository->paginate($product_id, $total);
	}

	public function getById(int $product_id, int $id): ProductVideo
	{
		return $this->videoRepository->getById($product_id, $id);
	}

	public function create(ProductVideoDTO $data, int $product_id): ProductVideo
	{
		return DB::transaction(function () use ($data, $product_id) {
			return $this->videoRepository->create($data->toArray(), $product_id);
		});
	}

	public function update(ProductVideoDTO $data, ProductVideo $video): ProductVideo
	{
		return DB::transaction(function () use ($data, $video) {
			return $this->videoRepository->update($video, $data->toArray());
		});
	}

	public function delete(ProductVideo $video): ProductVideo
	{
		return DB::transaction(function () use ($video) {
			return $this->videoRepository->delete($video);
		});
	}
}
