<?php

namespace App\Features\ProductImages\Resources;

use App\Http\Services\FileStorageService;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductImageCollection extends JsonResource
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
			'image_title' => $this->image_title,
			'image_alt' => $this->image_alt,
			'image' => $this->image,
			'image_url' => $this->image ? (new FileStorageService)->publicUrl($this->image) : null,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}