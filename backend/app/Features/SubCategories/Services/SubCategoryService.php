<?php

namespace App\Features\SubCategories\Services;

use App\Features\SubCategories\DTO\CategoryIdDTO;
use App\Features\SubCategories\DTO\SubCategoryDTO;
use App\Features\SubCategories\Exports\SubCategoryExport;
use App\Features\SubCategories\Interfaces\SubCategoryRepositoryInterface;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Features\SubCategories\Models\SubCategory;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class SubCategoryService implements SubCategoryServiceInterface
{

	public function __construct(private SubCategoryRepositoryInterface $subCategoryRepository) {}

	public function paginate(Int $total = 10, bool $withCategory = false): LengthAwarePaginator
	{
		return $this->subCategoryRepository->paginate($total, $withCategory);
	}

	public function getById(Int $id, bool $withCategory = false): SubCategory
	{
		return $this->subCategoryRepository->getById($id, $withCategory);
	}

	public function getBySlug(string $slug, bool $withCategory = false): SubCategory
	{
		return $this->subCategoryRepository->getByColumnOrFail('slug', $slug, $withCategory);
	}

	public function create(SubCategoryDTO $data, CategoryIdDTO $categoryIdDTO): SubCategory
	{
		return DB::transaction(function () use ($data, $categoryIdDTO) {
			$subCategory = $this->subCategoryRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
			$subCategory = $this->subCategoryRepository->syncCategories($subCategory, $categoryIdDTO->toArray());
			return $subCategory;
		});
	}

	public function update(SubCategoryDTO $data, CategoryIdDTO $categoryIdDTO, SubCategory $subCategory): SubCategory
	{
		return DB::transaction(function () use ($data, $categoryIdDTO, $subCategory) {
			$image = $subCategory->image;
			if($data->image){
				$image = $data->image;
			}
			$subCategory = $this->subCategoryRepository->update($subCategory, [...$data->toArray(), 'image' => $image]);
			$subCategory = $this->subCategoryRepository->syncCategories($subCategory, $categoryIdDTO->toArray());
			return $subCategory;
		});
	}

	public function toggleActive(SubCategory $subCategory): SubCategory
	{
		return DB::transaction(function () use ($subCategory) {
			return $this->subCategoryRepository->update($subCategory, ['is_active' => !$subCategory->is_active]);
		});
	}

	public function delete(SubCategory $subCategory): SubCategory
	{
		return DB::transaction(function () use ($subCategory) {
			return $this->subCategoryRepository->delete($subCategory);
		});
	}

	public function exportSubCategories(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new SubCategoryExport($this->subCategoryRepository->query(true)), 'sub_categories.xlsx');
	}
}
