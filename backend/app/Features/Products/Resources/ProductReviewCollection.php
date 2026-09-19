<?php

namespace App\Features\Products\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductReviewCollection extends JsonResource
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
			'rating' => $this->rating,
			'comment' => $this->comment,
			'is_active' => $this->is_active,
		];
	}
}