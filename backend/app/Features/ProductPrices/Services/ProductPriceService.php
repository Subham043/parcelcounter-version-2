<?php

namespace App\Features\ProductPrices\Services;

use App\Features\ProductPrices\DTO\ProductPriceDTO;
use App\Features\ProductPrices\Interfaces\ProductPriceRepositoryInterface;
use App\Features\ProductPrices\Interfaces\ProductPriceServiceInterface;
use App\Features\ProductPrices\Models\ProductPrice;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class ProductPriceService implements ProductPriceServiceInterface
{

	public function __construct(private ProductPriceRepositoryInterface $priceRepository) {}

	public function paginate(int $product_id, int $total = 10): LengthAwarePaginator
	{
		return $this->priceRepository->paginate($product_id, $total);
	}

	public function getById(int $product_id, int $id): ProductPrice
	{
		return $this->priceRepository->getById($product_id, $id);
	}

	public function create(ProductPriceDTO $data, int $product_id): ProductPrice
	{
		return DB::transaction(function () use ($data, $product_id) {
			return $this->priceRepository->create($data->toArray(), $product_id);
		});
	}

	public function update(ProductPriceDTO $data, ProductPrice $price): ProductPrice
	{
		return DB::transaction(function () use ($data, $price) {
			return $this->priceRepository->update($price, $data->toArray());
		});
	}

	public function delete(ProductPrice $price): ProductPrice
	{
		return DB::transaction(function () use ($price) {
			return $this->priceRepository->delete($price);
		});
	}
}
