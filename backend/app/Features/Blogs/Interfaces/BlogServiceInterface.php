<?php

namespace App\Features\Blogs\Interfaces;

use App\Features\Blogs\DTO\BlogDTO;
use App\Features\Blogs\Models\Blog;
use Illuminate\Pagination\LengthAwarePaginator;

interface BlogServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(BlogDTO $data): Blog;
    public function update(BlogDTO $data, Blog $blog): Blog;
    public function getById(int $id): Blog;
    public function getBySlug(string $slug): Blog;
    public function delete(Blog $blog): Blog;
    public function toggleActive(Blog $blog): Blog;
    public function exportBlogs(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
