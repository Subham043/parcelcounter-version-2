<?php

namespace App\Features\TexteditorImages\Services;

use App\Features\TexteditorImages\DTO\TexteditorImageDTO;
use App\Features\TexteditorImages\Interfaces\TexteditorImageRepositoryInterface;
use App\Features\TexteditorImages\Interfaces\TexteditorImageServiceInterface;
use App\Features\TexteditorImages\Models\TexteditorImage;
use App\Http\Enums\Guards;
use Illuminate\Support\Facades\DB;

class TexteditorImageService implements TexteditorImageServiceInterface
{

	public function __construct(private TexteditorImageRepositoryInterface $texteditorImageRepository) {}

	public function create(TexteditorImageDTO $data): TexteditorImage
	{
		return DB::transaction(function () use ($data) {
			return $this->texteditorImageRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}
}
