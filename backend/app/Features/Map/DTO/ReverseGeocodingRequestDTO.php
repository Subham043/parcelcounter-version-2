<?php

namespace App\Features\Map\DTO;

use App\Features\Map\Requests\ReverseGeocodingPostRequest;
use Illuminate\Support\Collection;

final class ReverseGeocodingRequestDTO
{
    public function __construct(
        public readonly float $lat,
        public readonly float $lng,
    ) {}

    /**
     * @param ReverseGeocodingPostRequest $request
     * @return self
     */
    public static function fromRequest(ReverseGeocodingPostRequest $request): self
    {
        return new self(
            lat: $request->validated('lat'),
            lng: $request->validated('lng'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];
    }

    /**
     * @extends \Illuminate\Support\Collection<int, ReverseGeocodingRequestDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
