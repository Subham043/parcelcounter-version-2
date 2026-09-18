<?php

namespace App\Features\Categories\Services;

use App\Features\Categories\DTO\CategoryDTO;
use App\Features\Categories\Exports\CategoryExport;
use App\Features\Categories\Interfaces\CategoryRepositoryInterface;
use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Features\Categories\Models\Category;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CategoryService implements CategoryServiceInterface
{

	public function __construct(private CategoryRepositoryInterface $categoryRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->categoryRepository->paginate($total);
	}

	public function getById(Int $id): Category
	{
		return $this->categoryRepository->getById($id);
	}

	public function getBySlug(string $slug): Category
	{
		return $this->categoryRepository->getByColumnOrFail('slug', $slug);
	}

	public function create(CategoryDTO $data): Category
	{
		return DB::transaction(function () use ($data) {
			return $this->categoryRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(CategoryDTO $data, Category $category): Category
	{
		return DB::transaction(function () use ($data, $category) {
			$image = $category->image;
			if($data->image){
				$image = $data->image;
			}
			return $this->categoryRepository->update($category, [...$data->toArray(), 'image' => $image]);
		});
	}

	public function toggleActive(Category $category): Category
	{
		return DB::transaction(function () use ($category) {
			return $this->categoryRepository->update($category, ['is_active' => !$category->is_active]);
		});
	}

	public function delete(Category $category): Category
	{
		return DB::transaction(function () use ($category) {
			return $this->categoryRepository->delete($category);
		});
	}

	public function exportCategories(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new CategoryExport($this->categoryRepository->query()), 'categorys.xlsx');
	}
}
