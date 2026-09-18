<?php

namespace App\Features\ProductPrices\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductPriceCollection extends JsonResource
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
			'price' => $this->price,
			'min_quantity' => $this->min_quantity,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}