<?php

namespace App\Features\Map\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ReverseGeocodingCollection extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'formatted_address' => $this->formatted_address,
            'name' => $this->name,
            'place_id' => $this->place_id,
            'city' => $this->city,
            'state' => $this->state,
            'pincode' => $this->pincode,
            'country' => $this->country,
            'geometry' => [
                'location' => [
                    'lng' => $this->geometry['location']['lng'] ?? null,
                    'lat' => $this->geometry['location']['lat'] ?? null,
                ],
            ],
        ];
    }
}