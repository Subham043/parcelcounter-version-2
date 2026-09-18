<?php

namespace App\Features\Products\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductTaxCollection extends JsonResource
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
			'value' => $this->value,
			'is_inter_state_tax' => $this->is_inter_state_tax,
		];
	}
}