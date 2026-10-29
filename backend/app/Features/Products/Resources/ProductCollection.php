<?php

namespace App\Features\Products\Resources;

use App\Features\Categories\Resources\RelatedCategoryCollection;
use App\Features\ProductColors\Resources\RelatedProductColorCollection;
use App\Features\ProductImages\Resources\RelatedProductImageCollection;
use App\Features\ProductPrices\Resources\RelatedProductPriceCollection;
use App\Features\ProductReviews\Resources\RelatedProductReviewCollection;
use App\Features\ProductSpecifications\Resources\RelatedProductSpecificationCollection;
use App\Features\ProductStocks\Resources\RelatedProductStockCollection;
use App\Features\ProductVideos\Resources\RelatedProductVideoCollection;
use App\Features\SubCategories\Resources\RelatedSubCategoryCollection;
use App\Features\Taxes\Resources\RelatedTaxCollection;
use App\Http\Services\FileStorageService;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductCollection extends JsonResource
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		return [
			'id' => $this->id,
			'name' => $this->name,
			'slug' => $this->slug,
			'hsn' => $this->hsn,
			'description' => $this->description,
			'description_unfiltered' => $this->description_unfiltered,
			'brief_description' => $this->brief_description,
			'image' => $this->image,
			'image_url' => $this->image ? (new FileStorageService)->publicUrl($this->image) : null,
			'is_active' => $this->is_active,
			'is_new' => $this->is_new,
			'is_on_sale' => $this->is_on_sale,
			'is_featured' => $this->is_featured,
			'min_cart_quantity' => $this->min_cart_quantity,
			'cart_quantity_interval' => $this->cart_quantity_interval,
			'cart_quantity_specification' => $this->cart_quantity_specification,
			'meta_title' => $this->meta_title,
			'meta_description' => $this->meta_description,
			'meta_keywords' => $this->meta_keywords,
			'user_id' => $this->user_id,
			'categories' => $this->when(
				$this->relationLoaded('categories'),
				fn () => RelatedCategoryCollection::collection($this->categories)
			),
			'sub_categories' => $this->when(
				$this->relationLoaded('sub_categories'),
				fn () => RelatedSubCategoryCollection::collection($this->sub_categories)
			),
			'taxes' => $this->when(
				$this->relationLoaded('taxes'),
				fn () => RelatedTaxCollection::collection($this->taxes)
			),
			'specifications' => $this->when(
				$this->relationLoaded('specifications'),
				fn () => RelatedProductSpecificationCollection::collection($this->specifications)
			),
			'images' => $this->when(
				$this->relationLoaded('images'),
				fn () => RelatedProductImageCollection::collection($this->images)
			),
			'videos' => $this->when(
				$this->relationLoaded('videos'),
				fn () => RelatedProductVideoCollection::collection($this->videos)
			),
			'colors' => $this->when(
				$this->relationLoaded('colors'),
				fn () => RelatedProductColorCollection::collection($this->colors)
			),
			'prices' => $this->when(
				$this->relationLoaded('prices'),
				fn () => RelatedProductPriceCollection::collection($this->prices)
			),
			'stocks' => $this->when(
				$this->relationLoaded('stocks'),
				fn () => RelatedProductStockCollection::collection($this->stocks)
			),
			'latest_stock' => $this->when(
				$this->relationLoaded('latest_stock'),
				fn () => RelatedProductStockCollection::make($this->latest_stock)
			),
			'reviews' => $this->when(
				$this->relationLoaded('reviews'),
				fn () => RelatedProductReviewCollection::collection($this->reviews)
			),
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}