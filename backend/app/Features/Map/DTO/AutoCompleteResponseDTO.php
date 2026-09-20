<?php

namespace App\Features\Map\DTO;

final class AutoCompleteResponseDTO
{
    public function __construct(
        public readonly string $description,
        public readonly array $geometry,
        public readonly string $place_id,
        public readonly ?string $city = null,
        public readonly ?string $state = null,
        public readonly ?string $pincode = null,
        public readonly ?string $country = null,
    ) {}

    public static function fromOla(array $item): self
    {
        $terms = collect($item['terms'] ?? [])
            ->pluck('value')
            ->values();

        $pincodeIndex = $terms->search(
            fn ($value) => preg_match('/^\d{6}$/', (string) $value)
        );

        $pincode = $pincodeIndex !== false
            ? $terms->get($pincodeIndex)
            : null;

        $country = $terms->last();

        $state = $pincodeIndex !== false
            ? $terms->get($pincodeIndex - 1)
            : null;

        $city = $pincodeIndex !== false
            ? $terms->get($pincodeIndex - 2)
            : null;

        return new self(
            description: $item['description'] ?? '',

            geometry: [
                'location' => [
                    'lng' => data_get($item, 'geometry.location.lng'),
                    'lat' => data_get($item, 'geometry.location.lat'),
                ],
            ],

            place_id: $item['place_id'] ?? '',

            city: $city,
            state: $state,
            pincode: $pincode,
            country: $country,
        );
    }
}