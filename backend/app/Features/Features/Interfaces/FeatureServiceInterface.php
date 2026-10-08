<?php

namespace App\Features\Features\Interfaces;

use App\Features\Features\DTO\FeatureDTO;
use App\Features\Features\DTO\FeatureFilterDTO;
use App\Features\Features\Models\Feature;
use Illuminate\Pagination\LengthAwarePaginator;

interface FeatureServiceInterface
{
    public function paginate(?FeatureFilterDTO $dto = null): LengthAwarePaginator;
    public function create(FeatureDTO $data): Feature;
    public function update(FeatureDTO $data, Feature $feature): Feature;
    public function getById(int $id): Feature;
    public function delete(Feature $feature): Feature;
    public function toggleActive(Feature $feature): Feature;
    public function exportFeatures(?FeatureFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
