<?php

namespace App\Features\Taxes\Services;

use App\Features\Taxes\DTO\TaxDTO;
use App\Features\Taxes\Exports\TaxExport;
use App\Features\Taxes\Interfaces\TaxRepositoryInterface;
use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Features\Taxes\Models\Tax;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TaxService implements TaxServiceInterface
{

	public function __construct(private TaxRepositoryInterface $taxRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->taxRepository->paginate($total);
	}

	public function getById(Int $id): Tax
	{
		return $this->taxRepository->getById($id);
	}

	public function getBySlug(string $slug): Tax
	{
		return $this->taxRepository->getByColumnOrFail('slug', $slug);
	}

	public function create(TaxDTO $data): Tax
	{
		return DB::transaction(function () use ($data) {
			return $this->taxRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(TaxDTO $data, Tax $tax): Tax
	{
		return DB::transaction(function () use ($data, $tax) {
			return $this->taxRepository->update($tax, $data->toArray());
		});
	}

	public function toggleActive(Tax $tax): Tax
	{
		return DB::transaction(function () use ($tax) {
			return $this->taxRepository->update($tax, ['is_active' => !$tax->is_active]);
		});
	}

	public function delete(Tax $tax): Tax
	{
		return DB::transaction(function () use ($tax) {
			return $this->taxRepository->delete($tax);
		});
	}

	public function exportTaxes(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new TaxExport($this->taxRepository->query()), 'taxes.xlsx');
	}
}
