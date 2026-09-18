<?php

namespace App\Features\AboutSections\Interfaces;

use App\Features\AboutSections\DTO\AboutSectionDTO;
use App\Features\AboutSections\Models\AboutSection;
use Illuminate\Pagination\LengthAwarePaginator;

interface AboutSectionServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(AboutSectionDTO $data): AboutSection;
    public function update(AboutSectionDTO $data, AboutSection $section): AboutSection;
    public function getById(int $id): AboutSection;
    public function delete(AboutSection $section): AboutSection;
    public function toggleActive(AboutSection $section): AboutSection;
    public function exportAboutSections(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
