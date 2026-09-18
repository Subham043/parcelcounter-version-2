<?php

namespace App\Features\BillingInformations\Interfaces;

use App\Features\BillingInformations\DTO\BillingInformationDTO;
use App\Features\BillingInformations\Models\BillingInformation;
use Illuminate\Pagination\LengthAwarePaginator;

interface BillingInformationServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(BillingInformationDTO $data): BillingInformation;
    public function update(BillingInformationDTO $data, BillingInformation $enquiry): BillingInformation;
    public function getById(int $id): BillingInformation;
    public function delete(BillingInformation $enquiry): BillingInformation;
    public function exportBillingInformations(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
