<?php

namespace App\Features\Map\DTO;

use App\Features\Map\Requests\AutoCompletePostRequest;
use Illuminate\Support\Collection;

final class AutoCompleteRequestDTO
{
    public function __construct(
        public readonly string $query,
        public readonly ?float $lat,
        public readonly ?float $lng,
    ) {}

    /**
     * @param AutoCompletePostRequest $request
     * @return self
     */
    public static function fromRequest(AutoCompletePostRequest $request): self
    {
        return new self(
            query: $request->validated('query'),
            lat: $request->validated('lat'),
            lng: $request->validated('lng'),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'query' => $this->query,
            'lat' => $this->lat,
            'lng' => $this->lng,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, AutoCompleteRequestDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
