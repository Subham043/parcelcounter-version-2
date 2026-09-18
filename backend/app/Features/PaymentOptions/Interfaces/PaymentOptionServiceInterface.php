<?php

namespace App\Features\PaymentOptions\Interfaces;

use App\Features\PaymentOptions\DTO\PaymentOptionDTO;
use App\Features\PaymentOptions\Models\PaymentOption;
use Illuminate\Pagination\LengthAwarePaginator;

interface PaymentOptionServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(PaymentOptionDTO $data): PaymentOption;
    public function update(PaymentOptionDTO $data, PaymentOption $option): PaymentOption;
    public function getById(int $id): PaymentOption;
    public function getBySlug(string $slug): PaymentOption;
    public function delete(PaymentOption $option): PaymentOption;
    public function toggleActive(PaymentOption $option): PaymentOption;
    public function exportPaymentOptions(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
