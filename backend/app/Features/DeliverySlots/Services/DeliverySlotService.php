<?php

namespace App\Features\DeliverySlots\Services;

use App\Features\DeliverySlots\DTO\DeliverySlotDTO;
use App\Features\DeliverySlots\Exports\DeliverySlotExport;
use App\Features\DeliverySlots\Interfaces\DeliverySlotRepositoryInterface;
use App\Features\DeliverySlots\Interfaces\DeliverySlotServiceInterface;
use App\Features\DeliverySlots\Models\DeliverySlot;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class DeliverySlotService implements DeliverySlotServiceInterface
{

	public function __construct(private DeliverySlotRepositoryInterface $slotRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->slotRepository->paginate($total);
	}

	public function getById(Int $id): DeliverySlot
	{
		return $this->slotRepository->getById($id);
	}

	public function create(DeliverySlotDTO $data): DeliverySlot
	{
		return DB::transaction(function () use ($data) {
			return $this->slotRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(DeliverySlotDTO $data, DeliverySlot $slot): DeliverySlot
	{
		return DB::transaction(function () use ($data, $slot) {
			return $this->slotRepository->update($slot, $data->toArray());
		});
	}

	public function toggleActive(DeliverySlot $slot): DeliverySlot
	{
		return DB::transaction(function () use ($slot) {
			return $this->slotRepository->update($slot, ['is_active' => !$slot->is_active]);
		});
	}

	public function delete(DeliverySlot $slot): DeliverySlot
	{
		return DB::transaction(function () use ($slot) {
			return $this->slotRepository->delete($slot);
		});
	}

	public function exportDeliverySlots(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new DeliverySlotExport($this->slotRepository->query()), 'slots.xlsx');
	}
}
