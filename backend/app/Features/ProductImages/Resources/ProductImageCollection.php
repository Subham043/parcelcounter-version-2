<?php

namespace App\Features\ProductImages\Resources;


class ProductImageCollection extends RelatedProductImageCollection
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
            'created_at' => $this->created_at,
			'updated_at' => $this->updated_at,
        ]);
	}
}