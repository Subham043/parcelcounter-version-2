<?php

namespace App\Features\Blogs\Interfaces;

use App\Features\Blogs\DTO\BlogDTO;
use App\Features\Blogs\DTO\BlogFilterDTO;
use App\Features\Blogs\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;

interface BlogServiceInterface
{
    public function paginate(?BlogFilterDTO $dto = null): LengthAwarePaginator;
    public function create(BlogDTO $data): Blog;
    public function update(BlogDTO $data, Blog $blog): Blog;
    public function getById(int $id): Blog;
    public function getBySlug(string $slug): Blog;
    public function delete(Blog $blog): Blog;
    public function toggleActive(Blog $blog): Blog;
    public function exportBlogs(?BlogFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
