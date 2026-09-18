<?php

namespace App\Features\SubCategories\Interfaces;

use App\Features\SubCategories\DTO\CategoryIdDTO;
use App\Features\SubCategories\DTO\SubCategoryDTO;
use App\Features\SubCategories\Models\SubCategory;
use Illuminate\Pagination\LengthAwarePaginator;

interface SubCategoryServiceInterface
{
    public function paginate(Int $total = 10, bool $withCategory = false): LengthAwarePaginator;
    public function create(SubCategoryDTO $data, CategoryIdDTO $categoryIdDTO): SubCategory;
    public function update(SubCategoryDTO $data, CategoryIdDTO $categoryIdDTO, SubCategory $subCategory): SubCategory;
    public function getById(int $id, bool $withCategory = false): SubCategory;
    public function getBySlug(string $slug, bool $withCategory = false): SubCategory;
    public function delete(SubCategory $subCategory): SubCategory;
    public function toggleActive(SubCategory $subCategory): SubCategory;
    public function exportSubCategories(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
