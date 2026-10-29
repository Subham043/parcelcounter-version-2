<?php

namespace App\Features\Taxes\Resources;

class TaxCollection extends RelatedTaxCollection
{
	/**
	 * Transform the resource collection into an array.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
	 */
	public function toArray($request)
	{
		$parentToArray = parent::toArray($request);
        return array_merge($parentToArray, [
			'is_active' => $this->is_active,
			'user_id' => $this->user_id,
            'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
        ]);
	}
}