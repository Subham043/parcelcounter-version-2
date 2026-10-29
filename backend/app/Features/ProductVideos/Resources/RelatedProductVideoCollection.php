<?php

namespace App\Features\ProductVideos\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RelatedProductVideoCollection extends JsonResource
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
			'video' => $this->video,
		];
	}
}