<?php

namespace App\Features\DeliverySlots\Interfaces;

use App\Features\DeliverySlots\DTO\DeliverySlotDTO;
use App\Features\DeliverySlots\Models\DeliverySlot;
use Illuminate\Pagination\LengthAwarePaginator;

interface DeliverySlotServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(DeliverySlotDTO $data): DeliverySlot;
    public function update(DeliverySlotDTO $data, DeliverySlot $slot): DeliverySlot;
    public function getById(int $id): DeliverySlot;
    public function delete(DeliverySlot $slot): DeliverySlot;
    public function toggleActive(DeliverySlot $slot): DeliverySlot;
    public function exportDeliverySlots(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
