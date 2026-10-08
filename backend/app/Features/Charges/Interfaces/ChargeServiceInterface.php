<?php

namespace App\Features\Charges\Interfaces;

use App\Features\Charges\DTO\ChargeDTO;
use App\Features\Charges\DTO\ChargeFilterDTO;
use App\Features\Charges\Models\Charge;
use Illuminate\Pagination\LengthAwarePaginator;

interface ChargeServiceInterface
{
    public function paginate(?ChargeFilterDTO $dto = null): LengthAwarePaginator;
    public function create(ChargeDTO $data): Charge;
    public function update(ChargeDTO $data, Charge $charge): Charge;
    public function getById(int $id): Charge;
    public function getBySlug(string $slug): Charge;
    public function delete(Charge $charge): Charge;
    public function toggleActive(Charge $charge): Charge;
    public function exportCharges(?ChargeFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
