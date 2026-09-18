<?php

namespace App\Features\LegalContents\Services;

use App\Features\LegalContents\DTO\LegalContentDTO;
use App\Features\LegalContents\Exports\LegalContentExport;
use App\Features\LegalContents\Interfaces\LegalContentRepositoryInterface;
use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Features\LegalContents\Models\LegalContent;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LegalContentService implements LegalContentServiceInterface
{

	public function __construct(private LegalContentRepositoryInterface $legalContentRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->legalContentRepository->paginate($total);
	}

	public function getById(Int $id): LegalContent
	{
		return $this->legalContentRepository->getById($id);
	}

	public function getBySlug(string $slug): LegalContent
	{
		return $this->legalContentRepository->getByColumnOrFail('slug', $slug);
	}

	public function create(LegalContentDTO $data): LegalContent
	{
		return DB::transaction(function () use ($data) {
			return $this->legalContentRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(LegalContentDTO $data, LegalContent $legalContent): LegalContent
	{
		return DB::transaction(function () use ($data, $legalContent) {
			return $this->legalContentRepository->update($legalContent, [...$data->toArray()]);
		});
	}

	public function toggleActive(LegalContent $legalContent): LegalContent
	{
		return DB::transaction(function () use ($legalContent) {
			return $this->legalContentRepository->update($legalContent, ['is_active' => !$legalContent->is_active]);
		});
	}

	public function delete(LegalContent $legalContent): LegalContent
	{
		return DB::transaction(function () use ($legalContent) {
			return $this->legalContentRepository->delete($legalContent);
		});
	}

	public function exportLegalContents(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new LegalContentExport($this->legalContentRepository->query()), 'legal_contents.xlsx');
	}
}
