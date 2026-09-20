<?php

namespace App\Features\Map\Interfaces;

use App\Features\Map\DTO\AutoCompleteRequestDTO;
use App\Features\Map\DTO\ReverseGeocodingRequestDTO;

interface MapServiceInterface
{
    public function getAutocomplete(AutoCompleteRequestDTO $data): array;
    public function getReverseGeocoding(ReverseGeocodingRequestDTO $data): array;
    public function getGeocoding(string $address): array;
    public function getPlaceInfoById(string $placeId): array;
    public function getDirection(
        float $originLat,
        float $originLng,
        float $destinationLat,
        float $destinationLng
    ): array;
    public function getOptimizedRoutes(string $locations): array;
}
