<?php

namespace App\Features\Categories\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelatedCategoryCollection extends JsonResource
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
		];
	}
}