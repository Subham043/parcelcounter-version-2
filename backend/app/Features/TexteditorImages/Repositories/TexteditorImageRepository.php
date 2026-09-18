<?php

namespace App\Features\TexteditorImages\Repositories;


use App\Features\TexteditorImages\Models\TexteditorImage;
use App\Features\TexteditorImages\Interfaces\TexteditorImageRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;

class TexteditorImageRepository implements TexteditorImageRepositoryInterface
{
    public function model(): Builder
    {
        return TexteditorImage::select('id', 'image', 'user_id', 'created_at', 'updated_at');
    }

    public function create(array $data): TexteditorImage
    {
        return $this->model()->create($data);
    }
}