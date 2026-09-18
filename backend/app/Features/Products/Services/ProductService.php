<?php

namespace App\Features\Products\Services;

use App\Features\Products\DTO\ProductCategoryIdDTO;
use App\Features\Products\DTO\ProductDTO;
use App\Features\Products\DTO\ProductSubCategoryIdDTO;
use App\Features\Products\DTO\ProductTaxIdDTO;
use App\Features\Products\Exports\ProductExport;
use App\Features\Products\Interfaces\ProductRepositoryInterface;
use App\Features\Products\Interfaces\ProductServiceInterface;
use App\Features\Products\Models\Product;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ProductService implements ProductServiceInterface
{

	public function __construct(private ProductRepositoryInterface $productRepository) {}

	public function paginate(Int $total = 10, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false): LengthAwarePaginator
	{
		return $this->productRepository->paginate($total, $withCategory, $withSubCategory, $withTax);
	}

	public function getById(Int $id, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false): Product
	{
		return $this->productRepository->getById($id, $withCategory, $withSubCategory, $withTax);
	}

	public function getBySlug(string $slug, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false): Product
	{
		return $this->productRepository->getByColumnOrFail('slug', $slug, $withCategory, $withSubCategory, $withTax);
	}

	public function create(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO, ProductSubCategoryIdDTO $subCategoryIdDTO, ProductTaxIdDTO $taxIdDTO): Product
	{
		return DB::transaction(function () use ($data, $categoryIdDTO, $subCategoryIdDTO, $taxIdDTO) {
			$product = $this->productRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
			$product = $this->productRepository->syncCategories($product, $categoryIdDTO->toArray());
			$product = $this->productRepository->syncSubCategories($product, $subCategoryIdDTO->toArray());
			$product = $this->productRepository->syncTaxes($product, $taxIdDTO->toArray());
			return $product;
		});
	}

	public function update(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO, ProductSubCategoryIdDTO $subCategoryIdDTO, ProductTaxIdDTO $taxIdDTO, Product $product): Product
	{
		return DB::transaction(function () use ($data, $categoryIdDTO, $subCategoryIdDTO, $taxIdDTO, $product) {
			$image = $product->image;
			if($data->image){
				$image = $data->image;
			}
			$product = $this->productRepository->update($product, [...$data->toArray(), 'image' => $image]);
			$product = $this->productRepository->syncCategories($product, $categoryIdDTO->toArray());
			$product = $this->productRepository->syncSubCategories($product, $subCategoryIdDTO->toArray());
			$product = $this->productRepository->syncTaxes($product, $taxIdDTO->toArray());
			return $product;
		});
	}

	public function toggleActive(Product $product): Product
	{
		return DB::transaction(function () use ($product) {
			return $this->productRepository->update($product, ['is_active' => !$product->is_active]);
		});
	}

	public function delete(Product $product): Product
	{
		return DB::transaction(function () use ($product) {
			return $this->productRepository->delete($product);
		});
	}

	public function exportProducts(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new ProductExport($this->productRepository->query(true, true, true)), 'products.xlsx');
	}
}
