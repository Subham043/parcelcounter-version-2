<?php

namespace App\Features\Banners\Resources;

use App\Http\Services\FileStorageService;
use Illuminate\Http\Resources\Json\JsonResource;

class BannerCollection extends JsonResource
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
			'alt' => $this->alt,
			'desktop_image' => $this->desktop_image,
			'desktop_image_url' => $this->desktop_image ? (new FileStorageService)->publicUrl($this->desktop_image) : null,
			'mobile_image' => $this->mobile_image,
			'mobile_image_url' => $this->mobile_image ? (new FileStorageService)->publicUrl($this->mobile_image) : null,
			'is_active' => $this->is_active,
			'user_id' => $this->user_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}