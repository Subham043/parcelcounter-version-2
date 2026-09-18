<?php

namespace App\Features\ProductImages\Services;

use App\Features\ProductImages\DTO\ProductImageDTO;
use App\Features\ProductImages\Interfaces\ProductImageRepositoryInterface;
use App\Features\ProductImages\Interfaces\ProductImageServiceInterface;
use App\Features\ProductImages\Models\ProductImage;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductImageService implements ProductImageServiceInterface
{

	public function __construct(private ProductImageRepositoryInterface $imageRepository) {}

	public function paginate(int $product_id, int $total = 10): LengthAwarePaginator
	{
		return $this->imageRepository->paginate($product_id, $total);
	}

	public function getById(int $product_id, int $id): ProductImage
	{
		return $this->imageRepository->getById($product_id, $id);
	}

	public function create(ProductImageDTO $data, int $product_id): ProductImage
	{
		return DB::transaction(function () use ($data, $product_id) {
			return $this->imageRepository->create($data->toArray(), $product_id);
		});
	}

	public function update(ProductImageDTO $data, ProductImage $image): ProductImage
	{
		return DB::transaction(function () use ($data, $image) {
			return $this->imageRepository->update($image, $data->toArray());
		});
	}

	public function delete(ProductImage $image): ProductImage
	{
		return DB::transaction(function () use ($image) {
			return $this->imageRepository->delete($image);
		});
	}
}
