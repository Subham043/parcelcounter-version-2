<?php

namespace App\Features\ProductSpecifications\Services;

use App\Features\ProductSpecifications\DTO\ProductSpecificationDTO;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationRepositoryInterface;
use App\Features\ProductSpecifications\Interfaces\ProductSpecificationServiceInterface;
use App\Features\ProductSpecifications\Models\ProductSpecification;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductSpecificationService implements ProductSpecificationServiceInterface
{

	public function __construct(private ProductSpecificationRepositoryInterface $specificationRepository) {}

	public function paginate(int $product_id, int $total = 10): LengthAwarePaginator
	{
		return $this->specificationRepository->paginate($product_id, $total);
	}

	public function getById(int $product_id, int $id): ProductSpecification
	{
		return $this->specificationRepository->getById($product_id, $id);
	}

	public function create(ProductSpecificationDTO $data, int $product_id): ProductSpecification
	{
		return DB::transaction(function () use ($data, $product_id) {
			return $this->specificationRepository->create($data->toArray(), $product_id);
		});
	}

	public function update(ProductSpecificationDTO $data, ProductSpecification $specification): ProductSpecification
	{
		return DB::transaction(function () use ($data, $specification) {
			return $this->specificationRepository->update($specification, $data->toArray());
		});
	}

	public function delete(ProductSpecification $specification): ProductSpecification
	{
		return DB::transaction(function () use ($specification) {
			return $this->specificationRepository->delete($specification);
		});
	}
}
