<?php

namespace App\Features\Taxes\Interfaces;

use App\Features\Taxes\DTO\TaxDTO;
use App\Features\Taxes\Models\Tax;
use Illuminate\Pagination\LengthAwarePaginator;

interface TaxServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(TaxDTO $data): Tax;
    public function update(TaxDTO $data, Tax $tax): Tax;
    public function getById(int $id): Tax;
    public function getBySlug(string $slug): Tax;
    public function delete(Tax $tax): Tax;
    public function toggleActive(Tax $tax): Tax;
    public function exportTaxes(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
