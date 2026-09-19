<?php

namespace App\Features\Products\Resources;

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
			'hsn' => $this->hsn,
			'slug' => $this->slug,
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
				fn () => ProductCategoryCollection::collection($this->categories)
			),
			'sub_categories' => $this->when(
				$this->relationLoaded('sub_categories'),
				fn () => ProductSubCategoryCollection::collection($this->sub_categories)
			),
			'taxes' => $this->when(
				$this->relationLoaded('taxes'),
				fn () => ProductTaxCollection::collection($this->taxes)
			),
			'specifications' => $this->when(
				$this->relationLoaded('specifications'),
				fn () => ProductSpecificationCollection::collection($this->specifications)
			),
			'images' => $this->when(
				$this->relationLoaded('images'),
				fn () => ProductImageCollection::collection($this->images)
			),
			'videos' => $this->when(
				$this->relationLoaded('videos'),
				fn () => ProductVideoCollection::collection($this->videos)
			),
			'colors' => $this->when(
				$this->relationLoaded('colors'),
				fn () => ProductColorCollection::collection($this->colors)
			),
			'prices' => $this->when(
				$this->relationLoaded('prices'),
				fn () => ProductPriceCollection::collection($this->prices)
			),
			'stocks' => $this->when(
				$this->relationLoaded('stocks'),
				fn () => ProductStockCollection::collection($this->stocks)
			),
			'latest_stock' => $this->when(
				$this->relationLoaded('latest_stock'),
				fn () => ProductStockCollection::make($this->latest_stock)
			),
			'reviews' => $this->when(
				$this->relationLoaded('reviews'),
				fn () => ProductReviewCollection::collection($this->reviews)
			),
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}