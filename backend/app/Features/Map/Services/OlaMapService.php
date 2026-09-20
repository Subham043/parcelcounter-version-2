<?php

namespace App\Features\Map\Services;

use App\Features\Map\DTO\AutoCompleteRequestDTO;
use App\Features\Map\DTO\ReverseGeocodingRequestDTO;
use App\Features\Map\Interfaces\MapServiceInterface;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use RuntimeException;

final class OlaMapService implements MapServiceInterface
{
    private string $projectId;
    private string $apiKey;
    private string $clientId;
    private string $clientSecret;
    private bool $enabled;

    private const AUTH_URL = 'https://account.olamaps.io/realms/olamaps/protocol/openid-connect/token';
    private const API_URL = 'https://api.olamaps.io';

    public function __construct()
    {
        $this->projectId = config('services.map.project_id');
        $this->apiKey = config('services.map.api_key');
        $this->clientId = config('services.map.client_id');
        $this->clientSecret = config('services.map.client_secret');
        $this->enabled = (bool) config('services.map.enabled');
    }

    /**
     * Get OAuth access token.
     */
    private function authenticate(): string
    {

        return Cache::remember(
            'ola_maps_access_token',
            now()->addMinutes(50),
            function () {
                $response = Http::asForm()
                    ->acceptJson()
                    ->timeout(10)
                    ->post(self::AUTH_URL, [
                        'grant_type' => 'client_credentials',
                        'scope' => 'openid',
                        'client_id' => $this->clientId,
                        'client_secret' => $this->clientSecret,
                    ]);

                $response->throw();

                $token = $response->json('access_token');

                if (!$token) {
                    throw new RuntimeException(
                        'OLA Maps authentication failed: access token missing.'
                    );
                }

                return $token;
            }
        );
    }

    /**
     * Make an authenticated OLA Maps API request.
     */
    private function request(string $method, string $url, array $data = []): Response
    {
        $token = $this->authenticate();

        $request = Http::withToken($token)
            ->acceptJson()
            ->timeout(10);

        if ($method === 'GET') {
            return $request->get($url, $data);
        }

        return $request->post($url, $data);
    }

    public function getAutocomplete(AutoCompleteRequestDTO $data): array
    {
        if (!$this->enabled) {
            return [];
        }

        $param = [
            'input' => $data->query,
            'api_key' => $this->apiKey,
        ];

        if(!empty($data->lat) && !empty($data->lng)){
            $param['location'] = $data->lat.','.$data->lng;
        }

        $response = $this->request(
            'GET',
            self::API_URL . '/places/v1/autocomplete',
            $param
        );

        $response->throw();

        return $response->json('predictions', []);
    }

    public function getReverseGeocoding(ReverseGeocodingRequestDTO $data): array
    {
        if (!$this->enabled) {
            return [];
        }

        $response = $this->request(
            'GET',
            self::API_URL . '/places/v1/reverse-geocode',
            [
                'latlng' => "{$data->lat},{$data->lng}",
                'api_key' => $this->apiKey,
            ]
        );

        $response->throw();

        return $response->json('results', []);
    }

    public function getGeocoding(string $address): array
    {
        if (!$this->enabled) {
            return [];
        }

        $response = $this->request(
            'GET',
            self::API_URL . '/places/v1/geocode',
            [
                'address' => $address,
                'api_key' => $this->apiKey,
            ]
        );

        $response->throw();

        return $response->json('geocodingResults', []);
    }
    
    public function isAddressValid(string $address): bool
    {
        if (!$this->enabled) {
            return false;
        }

        $response = $this->request(
            'GET',
            self::API_URL . '/places/v1/addressvalidation',
            [
                'address' => $address,
                'api_key' => $this->apiKey,
            ]
        );

        $response->throw();

        return $response->json('result.validated', false);
    }

    public function getPlaceInfoById(string $placeId): array
    {
        if (!$this->enabled) {
            return [];
        }

        $response = $this->request(
            'GET',
            self::API_URL . '/places/v1/details',
            [
                'place_id' => $placeId,
                'api_key' => $this->apiKey,
            ]
        );

        $response->throw();

        return $response->json();
    }

    public function getDirection(
        float $originLat,
        float $originLng,
        float $destinationLat,
        float $destinationLng
    ): array {
        if (!$this->enabled) {
            return [];
        }

        $response = $this->request(
            'POST',
            self::API_URL . '/routing/v1/directions',
            [
                'origin' => "{$originLat},{$originLng}",
                'destination' => "{$destinationLat},{$destinationLng}",
                'api_key' => $this->apiKey,
            ]
        );

        $response->throw();

        return $response->json();
    }

    public function getOptimizedRoutes(string $locations): array
    {
        if (!$this->enabled) {
            return [];
        }

        $response = $this->request(
            'POST',
            self::API_URL . '/routing/v1/routeOptimizer',
            [
                'locations' => $locations,
                'api_key' => $this->apiKey,
            ]
        );

        $response->throw();

        return $response->json();
    }
}
