<?php

namespace App\Features\SubCategories\Interfaces;

use App\Features\SubCategories\DTO\CategoryIdDTO;
use App\Features\SubCategories\DTO\SubCategoryDTO;
use App\Features\SubCategories\DTO\SubCategoryFilterDTO;
use App\Features\SubCategories\Models\SubCategory;
use Illuminate\Pagination\LengthAwarePaginator;

interface SubCategoryServiceInterface
{
    public function paginate(?SubCategoryFilterDTO $dto = null): LengthAwarePaginator;
    public function create(SubCategoryDTO $data, CategoryIdDTO $categoryIdDTO): SubCategory;
    public function update(SubCategoryDTO $data, CategoryIdDTO $categoryIdDTO, SubCategory $subCategory): SubCategory;
    public function getById(int $id, ?SubCategoryFilterDTO $dto = null): SubCategory;
    public function getBySlug(string $slug, ?SubCategoryFilterDTO $dto = null): SubCategory;
    public function delete(SubCategory $subCategory): SubCategory;
    public function toggleActive(SubCategory $subCategory): SubCategory;
    public function exportSubCategories(?SubCategoryFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
