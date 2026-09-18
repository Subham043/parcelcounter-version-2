<?php

namespace App\Features\LegalContents\Resources;

use App\Http\Services\FileStorageService;
use Illuminate\Http\Resources\Json\JsonResource;

class LegalContentCollection extends JsonResource
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
			'heading' => $this->heading,
			'slug' => $this->slug,
			'description' => $this->description,
			'description_unfiltered' => $this->description_unfiltered,
			'is_active' => $this->is_active,
			'meta_title' => $this->meta_title,
			'meta_description' => $this->meta_description,
			'meta_keywords' => $this->meta_keywords,
			'user_id' => $this->user_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}