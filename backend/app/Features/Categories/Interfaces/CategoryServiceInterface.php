<?php

namespace App\Features\Categories\Interfaces;

use App\Features\Categories\DTO\CategoryDTO;
use App\Features\Categories\DTO\CategoryFilterDTO;
use App\Features\Categories\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryServiceInterface
{
    public function paginate(?CategoryFilterDTO $dto = null): LengthAwarePaginator;
    public function create(CategoryDTO $data): Category;
    public function update(CategoryDTO $data, Category $category): Category;
    public function getById(int $id): Category;
    public function getBySlug(string $slug): Category;
    public function delete(Category $category): Category;
    public function toggleActive(Category $category): Category;
    public function exportCategories(?CategoryFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
