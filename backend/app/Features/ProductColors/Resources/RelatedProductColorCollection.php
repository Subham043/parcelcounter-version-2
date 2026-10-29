<?php

namespace App\Features\ProductColors\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelatedProductColorCollection extends JsonResource
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
			'code' => $this->code,
		];
	}
}