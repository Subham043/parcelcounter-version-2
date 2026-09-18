<?php

namespace App\Features\Charges\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChargeCollection extends JsonResource
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
			'is_percentage' => $this->is_percentage,
			'include_charges_for_cart_price_below' => $this->include_charges_for_cart_price_below,
			'is_active' => $this->is_active,
			'user_id' => $this->user_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}