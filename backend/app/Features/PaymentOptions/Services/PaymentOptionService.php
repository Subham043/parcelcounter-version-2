<?php

namespace App\Features\PaymentOptions\Services;

use App\Features\PaymentOptions\DTO\PaymentOptionDTO;
use App\Features\PaymentOptions\Exports\PaymentOptionExport;
use App\Features\PaymentOptions\Interfaces\PaymentOptionRepositoryInterface;
use App\Features\PaymentOptions\Interfaces\PaymentOptionServiceInterface;
use App\Features\PaymentOptions\Models\PaymentOption;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PaymentOptionService implements PaymentOptionServiceInterface
{

	public function __construct(private PaymentOptionRepositoryInterface $optionRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->optionRepository->paginate($total);
	}

	public function getById(Int $id): PaymentOption
	{
		return $this->optionRepository->getById($id);
	}

	public function getBySlug(string $slug): PaymentOption
	{
		return $this->optionRepository->getByColumnOrFail('slug', $slug);
	}

	public function create(PaymentOptionDTO $data): PaymentOption
	{
		return DB::transaction(function () use ($data) {
			return $this->optionRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(PaymentOptionDTO $data, PaymentOption $option): PaymentOption
	{
		return DB::transaction(function () use ($data, $option) {
			$image = $option->image;
			if($data->image){
				$image = $data->image;
			}
			return $this->optionRepository->update($option, [...$data->toArray(), 'image' => $image]);
		});
	}

	public function toggleActive(PaymentOption $option): PaymentOption
	{
		return DB::transaction(function () use ($option) {
			return $this->optionRepository->update($option, ['is_active' => !$option->is_active]);
		});
	}

	public function delete(PaymentOption $option): PaymentOption
	{
		return DB::transaction(function () use ($option) {
			return $this->optionRepository->delete($option);
		});
	}

	public function exportPaymentOptions(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new PaymentOptionExport($this->optionRepository->query()), 'payment-options.xlsx');
	}
}
