<?php

namespace App\Features\BillingInformations\Services;

use App\Features\BillingInformations\DTO\BillingInformationDTO;
use App\Features\BillingInformations\Exports\BillingInformationExport;
use App\Features\BillingInformations\Interfaces\BillingInformationRepositoryInterface;
use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Features\BillingInformations\Models\BillingInformation;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class BillingInformationService implements BillingInformationServiceInterface
{

	public function __construct(private BillingInformationRepositoryInterface $informationRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->informationRepository->paginate(auth(Guards::API->value())->user()->id, $total);
	}

	public function getById(Int $id): BillingInformation
	{
		return $this->informationRepository->getById(auth(Guards::API->value())->user()->id, $id);
	}

	public function create(BillingInformationDTO $data): BillingInformation
	{
		return DB::transaction(function () use ($data) {
			return $this->informationRepository->create(auth(Guards::API->value())->user()->id, $data->toArray());
		});
	}

	public function update(BillingInformationDTO $data, BillingInformation $information): BillingInformation
	{
		return DB::transaction(function () use ($data, $information) {
			return $this->informationRepository->update($information, $data->toArray());
		});
	}

	public function delete(BillingInformation $information): BillingInformation
	{
		return DB::transaction(function () use ($information) {
			return $this->informationRepository->delete($information);
		});
	}

	public function exportBillingInformations(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new BillingInformationExport($this->informationRepository->query(auth(Guards::API->value())->user()->id)), 'billing_informations.xlsx');
	}
}
