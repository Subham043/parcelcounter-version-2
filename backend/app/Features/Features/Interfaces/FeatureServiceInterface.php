<?php

namespace App\Features\Features\Interfaces;

use App\Features\Features\DTO\FeatureDTO;
use App\Features\Features\Models\Feature;
use Illuminate\Pagination\LengthAwarePaginator;

interface FeatureServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(FeatureDTO $data): Feature;
    public function update(FeatureDTO $data, Feature $feature): Feature;
    public function getById(int $id): Feature;
    public function delete(Feature $feature): Feature;
    public function toggleActive(Feature $feature): Feature;
    public function exportFeatures(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
