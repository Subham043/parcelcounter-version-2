<?php

namespace App\Features\TexteditorImages\Interfaces;

use App\Features\TexteditorImages\Models\TexteditorImage;
use Illuminate\Database\Eloquent\Builder;

interface TexteditorImageRepositoryInterface
{
    public function model(): Builder;
    public function create(array $data): TexteditorImage;
}
