<?php

namespace App\Features\TexteditorImages\Interfaces;

use App\Features\TexteditorImages\DTO\TexteditorImageDTO;
use App\Features\TexteditorImages\Models\TexteditorImage;

interface TexteditorImageServiceInterface
{
    public function create(TexteditorImageDTO $data): TexteditorImage;
}
