<?php

namespace App\Features\Products\Services;

use App\Features\Products\DTO\ProductCategoryIdDTO;
use App\Features\Products\DTO\ProductColorDTO;
use App\Features\Products\DTO\ProductDTO;
use App\Features\Products\DTO\ProductImageDTO;
use App\Features\Products\DTO\ProductPriceDTO;
use App\Features\Products\DTO\ProductSpecificationDTO;
use App\Features\Products\DTO\ProductStockDTO;
use App\Features\Products\DTO\ProductSubCategoryIdDTO;
use App\Features\Products\DTO\ProductTaxIdDTO;
use App\Features\Products\DTO\ProductVideoDTO;
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

	public function paginate(Int $total = 10, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): LengthAwarePaginator
	{
		return $this->productRepository->paginate($total, $withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview);
	}

	public function getById(Int $id, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Product
	{
		return $this->productRepository->getById($id, $withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview);
	}

	public function getBySlug(string $slug, bool $withCategory = false, bool $withSubCategory = false, bool $withTax = false, bool $withSpecification = false, bool $withImage = false, bool $withVideo = false, bool $withColors = false, bool $withPrice = false, bool $withStock = false, bool $withLatestStock = false, bool $withReview = false): Product
	{
		return $this->productRepository->getByColumnOrFail('slug', $slug, $withCategory, $withSubCategory, $withTax, $withSpecification, $withImage, $withVideo, $withColors, $withPrice, $withStock, $withLatestStock, $withReview);
	}

	public function create(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO, ProductSubCategoryIdDTO $subCategoryIdDTO, ProductTaxIdDTO $taxIdDTO, ProductSpecificationDTO $specificationDTO, ProductPriceDTO $priceDTO, ProductStockDTO $stockDTO, ProductColorDTO $colorDTO, ProductVideoDTO $videoDTO, ProductImageDTO $imageDTO): Product
	{
		return DB::transaction(function () use ($data, $categoryIdDTO, $subCategoryIdDTO, $taxIdDTO, $specificationDTO, $priceDTO, $stockDTO, $colorDTO, $videoDTO, $imageDTO) {
			$product = $this->productRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
			$product = $this->productRepository->syncCategories($product, $categoryIdDTO->toArray());
			$product = $this->productRepository->syncSubCategories($product, $subCategoryIdDTO->toArray());
			$product = $this->productRepository->syncTaxes($product, $taxIdDTO->toArray());
			$product = $this->productRepository->saveSpecifications($product, $specificationDTO->toArray());
			$product = $this->productRepository->savePrices($product, $priceDTO->toArray());
			$product = $this->productRepository->saveStocks($product, $stockDTO->toArray());
			$product = $this->productRepository->saveColors($product, $colorDTO->toArray());
			$product = $this->productRepository->saveVideos($product, $videoDTO->toArray());
			$product = $this->productRepository->saveImages($product, $imageDTO->toArray());
			return $product;
		});
	}

	public function update(ProductDTO $data, ProductCategoryIdDTO $categoryIdDTO, ProductSubCategoryIdDTO $subCategoryIdDTO, ProductTaxIdDTO $taxIdDTO, ProductSpecificationDTO $specificationDTO, ProductPriceDTO $priceDTO, ProductStockDTO $stockDTO, ProductColorDTO $colorDTO, ProductVideoDTO $videoDTO, ProductImageDTO $imageDTO, Product $product): Product
	{
		return DB::transaction(function () use ($data, $categoryIdDTO, $subCategoryIdDTO, $taxIdDTO, $specificationDTO, $priceDTO, $stockDTO, $colorDTO, $videoDTO, $imageDTO, $product) {
			$image = $product->image;
			if($data->image){
				$image = $data->image;
			}
			$product = $this->productRepository->update($product, [...$data->toArray(), 'image' => $image]);
			$product = $this->productRepository->syncCategories($product, $categoryIdDTO->toArray());
			$product = $this->productRepository->syncSubCategories($product, $subCategoryIdDTO->toArray());
			$product = $this->productRepository->syncTaxes($product, $taxIdDTO->toArray());
			$product = $this->productRepository->saveSpecifications($product, $specificationDTO->toArray());
			$product = $this->productRepository->savePrices($product, $priceDTO->toArray());
			$product = $this->productRepository->saveStocks($product, $stockDTO->toArray());
			$product = $this->productRepository->saveColors($product, $colorDTO->toArray());
			$product = $this->productRepository->saveVideos($product, $videoDTO->toArray());
			$product = $this->productRepository->saveImages($product, $imageDTO->toArray());
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
