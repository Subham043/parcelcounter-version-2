<?php

namespace App\Features\AboutSections\Services;

use App\Features\AboutSections\DTO\AboutSectionDTO;
use App\Features\AboutSections\Exports\AboutSectionExport;
use App\Features\AboutSections\Interfaces\AboutSectionRepositoryInterface;
use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Features\AboutSections\Models\AboutSection;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class AboutSectionService implements AboutSectionServiceInterface
{

	public function __construct(private AboutSectionRepositoryInterface $sectionRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->sectionRepository->paginate($total);
	}

	public function getById(Int $id): AboutSection
	{
		return $this->sectionRepository->getById($id);
	}

	public function create(AboutSectionDTO $data): AboutSection
	{
		return DB::transaction(function () use ($data) {
			return $this->sectionRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(AboutSectionDTO $data, AboutSection $section): AboutSection
	{
		return DB::transaction(function () use ($data, $section) {
			$image = $section->image;
			if($data->image){
				$image = $data->image;
			}
			return $this->sectionRepository->update($section, [...$data->toArray(), 'image' => $image]);
		});
	}

	public function toggleActive(AboutSection $section): AboutSection
	{
		return DB::transaction(function () use ($section) {
			return $this->sectionRepository->update($section, ['is_active' => !$section->is_active]);
		});
	}

	public function delete(AboutSection $section): AboutSection
	{
		return DB::transaction(function () use ($section) {
			return $this->sectionRepository->delete($section);
		});
	}

	public function exportAboutSections(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new AboutSectionExport($this->sectionRepository->query()), 'sections.xlsx');
	}
}
