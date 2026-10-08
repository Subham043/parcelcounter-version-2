<?php

namespace App\Features\SubCategories\Resources;

use App\Http\Services\FileStorageService;
use Illuminate\Http\Resources\Json\JsonResource;

class SubCategoryCollection extends JsonResource
{
	private function showData(\Illuminate\Http\Request $request, string $key) {
		return $this->when(
				$request->query('is-select') != 'yes',
				$this->$key
			);
	}

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
			'heading' => $this->showData($request, 'heading'),
			'description' => $this->showData($request, 'description'),
			'description_unfiltered' => $this->showData($request, 'description_unfiltered'),
			'image' => $this->showData($request, 'image'),
			'image_url' => $this->when(
				$request->query('is-select') != 'yes',
				$this->image ? (new FileStorageService)->publicUrl($this->image) : null
			),
			'is_active' => $this->showData($request, 'is_active'),
			'meta_title' => $this->showData($request, 'meta_title'),
			'meta_description' => $this->showData($request, 'meta_description'),
			'meta_keywords' => $this->showData($request, 'meta_keywords'),
			'user_id' => $this->showData($request, 'user_id'),
			'created_at' => $this->showData($request, 'created_at'),
			'updated_at' => $this->showData($request, 'updated_at'),
			'categories' => $this->when(
				$this->relationLoaded('categories'),
				fn () => CategoryCollection::collection($this->categories)
			),
		];
	}
}