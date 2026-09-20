<?php

namespace App\Features\GlobalSearch\Resources;

use App\Http\Services\FileStorageService;
use Illuminate\Http\Resources\Json\JsonResource;

class GlobalSearchCollection extends JsonResource
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
            'search_type' => $this->type,
            'image' => $this->image,
			'image_url' => $this->image ? (new FileStorageService)->publicUrl($this->image) : null,
        ];
    }
}