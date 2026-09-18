<?php

namespace App\Features\Categories\Interfaces;

use App\Features\Categories\DTO\CategoryDTO;
use App\Features\Categories\Models\Category;
use Illuminate\Pagination\LengthAwarePaginator;

interface CategoryServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(CategoryDTO $data): Category;
    public function update(CategoryDTO $data, Category $category): Category;
    public function getById(int $id): Category;
    public function getBySlug(string $slug): Category;
    public function delete(Category $category): Category;
    public function toggleActive(Category $category): Category;
    public function exportCategories(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
