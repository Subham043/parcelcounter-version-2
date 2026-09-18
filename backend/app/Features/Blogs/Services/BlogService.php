<?php

namespace App\Features\Blogs\Services;

use App\Features\Blogs\DTO\BlogDTO;
use App\Features\Blogs\Exports\BlogExport;
use App\Features\Blogs\Interfaces\BlogRepositoryInterface;
use App\Features\Blogs\Interfaces\BlogServiceInterface;
use App\Features\Blogs\Models\Blog;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BlogService implements BlogServiceInterface
{

	public function __construct(private BlogRepositoryInterface $blogRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->blogRepository->paginate($total);
	}

	public function getById(Int $id): Blog
	{
		return $this->blogRepository->getById($id);
	}

	public function getBySlug(string $slug): Blog
	{
		return $this->blogRepository->getByColumnOrFail('slug', $slug);
	}

	public function create(BlogDTO $data): Blog
	{
		return DB::transaction(function () use ($data) {
			return $this->blogRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(BlogDTO $data, Blog $blog): Blog
	{
		return DB::transaction(function () use ($data, $blog) {
			$image = $blog->image;
			if($data->image){
				$image = $data->image;
			}
			return $this->blogRepository->update($blog, [...$data->toArray(), 'image' => $image]);
		});
	}

	public function toggleActive(Blog $blog): Blog
	{
		return DB::transaction(function () use ($blog) {
			return $this->blogRepository->update($blog, ['is_active' => !$blog->is_active]);
		});
	}

	public function delete(Blog $blog): Blog
	{
		return DB::transaction(function () use ($blog) {
			return $this->blogRepository->delete($blog);
		});
	}

	public function exportBlogs(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new BlogExport($this->blogRepository->query()), 'blogs.xlsx');
	}
}
