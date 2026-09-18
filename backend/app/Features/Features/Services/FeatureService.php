<?php

namespace App\Features\Features\Services;

use App\Features\Features\DTO\FeatureDTO;
use App\Features\Features\Exports\FeatureExport;
use App\Features\Features\Interfaces\FeatureRepositoryInterface;
use App\Features\Features\Interfaces\FeatureServiceInterface;
use App\Features\Features\Models\Feature;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class FeatureService implements FeatureServiceInterface
{

	public function __construct(private FeatureRepositoryInterface $featureRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->featureRepository->paginate($total);
	}

	public function getById(Int $id): Feature
	{
		return $this->featureRepository->getById($id);
	}

	public function create(FeatureDTO $data): Feature
	{
		return DB::transaction(function () use ($data) {
			return $this->featureRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(FeatureDTO $data, Feature $feature): Feature
	{
		return DB::transaction(function () use ($data, $feature) {
			$image = $feature->image;
			if($data->image){
				$image = $data->image;
			}
			return $this->featureRepository->update($feature, [...$data->toArray(), 'image' => $image]);
		});
	}

	public function toggleActive(Feature $feature): Feature
	{
		return DB::transaction(function () use ($feature) {
			return $this->featureRepository->update($feature, ['is_active' => !$feature->is_active]);
		});
	}

	public function delete(Feature $feature): Feature
	{
		return DB::transaction(function () use ($feature) {
			return $this->featureRepository->delete($feature);
		});
	}

	public function exportFeatures(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new FeatureExport($this->featureRepository->query()), 'features.xlsx');
	}
}
