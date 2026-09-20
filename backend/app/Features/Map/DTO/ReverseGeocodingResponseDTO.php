<?php

namespace App\Features\Map\DTO;

final class ReverseGeocodingResponseDTO
{
    public function __construct(
        public readonly ?string $formatted_address,
        public readonly ?string $name,
        public readonly ?string $place_id,
        public readonly ?string $city,
        public readonly ?string $state,
        public readonly ?string $pincode,
        public readonly ?string $country,
        public readonly array $geometry,
    ) {}

    public static function fromOla(array $item): self
    {
        $components = collect($item['address_components'] ?? []);

        $getComponent = function (string $type) use ($components): ?string {
            $component = $components->first(
                fn (array $component) =>
                    in_array($type, $component['types'] ?? [], true)
            );

            return $component['long_name'] ?? null;
        };

        return new self(
            formatted_address: $item['formatted_address'] ?? null,

            name: $item['name'] ?? null,

            place_id: $item['place_id'] ?? null,

            city: $getComponent('locality'),

            state: $getComponent('administrative_area_level_1'),

            pincode: $getComponent('postal_code'),

            country: $getComponent('country'),

            geometry: [
                'location' => [
                    'lng' => data_get($item, 'geometry.location.lng'),
                    'lat' => data_get($item, 'geometry.location.lat'),
                ],
            ],
        );
    }
}