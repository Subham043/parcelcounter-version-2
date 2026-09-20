<?php

namespace App\Features\Map\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutoCompleteCollection extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'description' => $this->description,
            'geometry' => $this->geometry,
            'place_id' => $this->place_id,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'country' => $this->country,
        ];
    }
}