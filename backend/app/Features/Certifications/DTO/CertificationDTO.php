<?php

namespace App\Features\Certifications\DTO;

use App\Features\Certifications\Requests\CertificationCreatePostRequest;
use App\Features\Certifications\Requests\CertificationUpdatePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class CertificationDTO
{
    public function __construct(
        public readonly ?string $title,
        public readonly ?string $image,
        public readonly bool $is_active,
    ) {}

    /**
     * @param CertificationCreatePostRequest|CertificationUpdatePostRequest $request
     * @return self
     */
    public static function fromRequest(CertificationCreatePostRequest|CertificationUpdatePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'certifications');
        }
        return new self(
            title: $request->validated('title') ?? null,
            image: $image,
            is_active: $request->validated('is_active') ?? true,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $data = [
            'title' => $this->title,
            'image' => $this->image,
            'is_active' => $this->is_active,
        ];

        return $data;
    }

    /**
     * @extends \Illuminate\Support\Collection<int, CertificationDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
