<?php

namespace App\Features\ProductStocks\Services;

use App\Features\ProductStocks\DTO\ProductStockDTO;
use App\Features\ProductStocks\Interfaces\ProductStockRepositoryInterface;
use App\Features\ProductStocks\Interfaces\ProductStockServiceInterface;
use App\Features\ProductStocks\Models\ProductStock;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductStockService implements ProductStockServiceInterface
{

	public function __construct(private ProductStockRepositoryInterface $stockRepository) {}

	public function paginate(int $product_id, int $total = 10): LengthAwarePaginator
	{
		return $this->stockRepository->paginate($product_id, $total);
	}

	public function getById(int $product_id, int $id): ProductStock
	{
		return $this->stockRepository->getById($product_id, $id);
	}

	public function create(ProductStockDTO $data, int $product_id): ProductStock
	{
		return DB::transaction(function () use ($data, $product_id) {
			return $this->stockRepository->create($data->toArray(), $product_id);
		});
	}

	public function update(ProductStockDTO $data, ProductStock $stock): ProductStock
	{
		return DB::transaction(function () use ($data, $stock) {
			return $this->stockRepository->update($stock, $data->toArray());
		});
	}

	public function delete(ProductStock $stock): ProductStock
	{
		return DB::transaction(function () use ($stock) {
			return $this->stockRepository->delete($stock);
		});
	}
}
