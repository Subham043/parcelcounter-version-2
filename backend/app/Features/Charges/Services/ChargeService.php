<?php

namespace App\Features\Charges\Services;

use App\Features\Charges\DTO\ChargeDTO;
use App\Features\Charges\Exports\ChargeExport;
use App\Features\Charges\Interfaces\ChargeRepositoryInterface;
use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Features\Charges\Models\Charge;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ChargeService implements ChargeServiceInterface
{

	public function __construct(private ChargeRepositoryInterface $chargeRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->chargeRepository->paginate($total);
	}

	public function getById(Int $id): Charge
	{
		return $this->chargeRepository->getById($id);
	}

	public function getBySlug(string $slug): Charge
	{
		return $this->chargeRepository->getByColumnOrFail('slug', $slug);
	}

	public function create(ChargeDTO $data): Charge
	{
		return DB::transaction(function () use ($data) {
			return $this->chargeRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(ChargeDTO $data, Charge $charge): Charge
	{
		return DB::transaction(function () use ($data, $charge) {
			return $this->chargeRepository->update($charge, $data->toArray());
		});
	}

	public function toggleActive(Charge $charge): Charge
	{
		return DB::transaction(function () use ($charge) {
			return $this->chargeRepository->update($charge, ['is_active' => !$charge->is_active]);
		});
	}

	public function delete(Charge $charge): Charge
	{
		return DB::transaction(function () use ($charge) {
			return $this->chargeRepository->delete($charge);
		});
	}

	public function exportCharges(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new ChargeExport($this->chargeRepository->query()), 'charges.xlsx');
	}
}
