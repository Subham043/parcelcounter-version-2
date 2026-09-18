<?php

namespace App\Features\Taxes\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaxCollection extends JsonResource
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
			'is_active' => $this->is_active,
			'user_id' => $this->user_id,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}