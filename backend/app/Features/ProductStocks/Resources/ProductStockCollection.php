<?php

namespace App\Features\ProductStocks\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProductStockCollection extends JsonResource
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
			'purchase_stock' => $this->purchase_stock,
			'quantity' => $this->quantity,
			'remaining_quantity' => $this->remaining_quantity,
			'purchased_at' => $this->purchased_at,
			'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
		];
	}
}