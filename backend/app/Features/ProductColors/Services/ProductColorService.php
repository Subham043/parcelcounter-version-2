<?php

namespace App\Features\ProductColors\Services;

use App\Features\ProductColors\DTO\ProductColorDTO;
use App\Features\ProductColors\Interfaces\ProductColorRepositoryInterface;
use App\Features\ProductColors\Interfaces\ProductColorServiceInterface;
use App\Features\ProductColors\Models\ProductColor;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductColorService implements ProductColorServiceInterface
{

	public function __construct(private ProductColorRepositoryInterface $colorRepository) {}

	public function paginate(int $product_id, int $total = 10): LengthAwarePaginator
	{
		return $this->colorRepository->paginate($product_id, $total);
	}

	public function getById(int $product_id, int $id): ProductColor
	{
		return $this->colorRepository->getById($product_id, $id);
	}

	public function create(ProductColorDTO $data, int $product_id): ProductColor
	{
		return DB::transaction(function () use ($data, $product_id) {
			return $this->colorRepository->create($data->toArray(), $product_id);
		});
	}

	public function update(ProductColorDTO $data, ProductColor $color): ProductColor
	{
		return DB::transaction(function () use ($data, $color) {
			return $this->colorRepository->update($color, $data->toArray());
		});
	}

	public function delete(ProductColor $color): ProductColor
	{
		return DB::transaction(function () use ($color) {
			return $this->colorRepository->delete($color);
		});
	}
}
