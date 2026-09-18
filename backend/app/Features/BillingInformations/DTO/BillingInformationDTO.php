<?php

namespace App\Features\BillingInformations\DTO;

use App\Features\BillingInformations\Requests\BillingInformationPostRequest;
use Illuminate\Support\Collection;

final class BillingInformationDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly ?string $gst,
    ) {}

    /**
     * @param BillingInformationPostRequest $request
     * @return self
     */
    public static function fromRequest(BillingInformationPostRequest $request): self
    {
        return new self(
            name: $request->validated('name'),
            email: $request->validated('email'),
            phone: $request->validated('phone'),
            gst: $request->validated('gst') ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gst' => $this->gst,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, BillingInformationDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
