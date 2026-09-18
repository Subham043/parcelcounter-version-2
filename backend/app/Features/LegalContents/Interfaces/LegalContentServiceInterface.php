<?php

namespace App\Features\LegalContents\Interfaces;

use App\Features\LegalContents\DTO\LegalContentDTO;
use App\Features\LegalContents\Models\LegalContent;
use Illuminate\Pagination\LengthAwarePaginator;

interface LegalContentServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(LegalContentDTO $data): LegalContent;
    public function update(LegalContentDTO $data, LegalContent $legalContent): LegalContent;
    public function getById(int $id): LegalContent;
    public function getBySlug(string $slug): LegalContent;
    public function delete(LegalContent $legalContent): LegalContent;
    public function toggleActive(LegalContent $legalContent): LegalContent;
    public function exportLegalContents(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
