<?php

namespace App\Features\Features\Resources;

use App\Http\Services\FileStorageService;
use Illuminate\Http\Resources\Json\JsonResource;

class FeatureCollection extends JsonResource
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
			'title' => $this->title,
			'description' => $this->description,
			'image' => $this->image,
			'image_url' => $this->image ? (new FileStorageService)->publicUrl($this->image) : null,
			'is_active' => $this->is_active,
			'user_id' => $this->user_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}