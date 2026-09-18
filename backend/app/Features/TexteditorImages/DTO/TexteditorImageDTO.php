<?php

namespace App\Features\TexteditorImages\DTO;

use App\Features\TexteditorImages\Requests\TexteditorImagePostRequest;
use App\Http\Services\FileStorageService;
use Illuminate\Support\Collection;

final class TexteditorImageDTO
{
    public function __construct(
        public readonly string $image,
    ) {}

    /**
     * @param TexteditorImagePostRequest $request
     * @return self
     */
    public static function fromRequest(TexteditorImagePostRequest $request): self
    {
        $image = null;
        if($request->hasFile('image')){
            $image = (new FileStorageService)->uploadPublic($request->file('image'), 'texteditor-images');
        }
        return new self(
            image: $image,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'image' => $this->image,
        ];
    }

    /**
     * @extends \Illuminate\Support\Collection<int, TexteditorImageDTO>
     */
    public function toCollection(): Collection
    {
        return collect($this->toArray());
    }
}
