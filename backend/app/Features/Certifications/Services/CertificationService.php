<?php

namespace App\Features\Certifications\Services;

use App\Features\Certifications\DTO\CertificationDTO;
use App\Features\Certifications\DTO\CertificationFilterDTO;
use App\Features\Certifications\Exports\CertificationExport;
use App\Features\Certifications\Interfaces\CertificationRepositoryInterface;
use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Features\Certifications\Models\Certification;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class CertificationService implements CertificationServiceInterface
{

	public function __construct(private CertificationRepositoryInterface $certificationRepository) {}

	public function paginate(?CertificationFilterDTO $dto = null): LengthAwarePaginator
	{
		return $this->certificationRepository->paginate($dto);
	}

	public function getById(Int $id): Certification
	{
		return $this->certificationRepository->getById($id);
	}

	public function create(CertificationDTO $data): Certification
	{
		return DB::transaction(function () use ($data) {
			return $this->certificationRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(CertificationDTO $data, Certification $certification): Certification
	{
		return DB::transaction(function () use ($data, $certification) {
			$image = $certification->image;
			if($data->image){
				$image = $data->image;
			}
			return $this->certificationRepository->update($certification, [...$data->toArray(), 'image' => $image]);
		});
	}

	public function toggleActive(Certification $certification): Certification
	{
		return DB::transaction(function () use ($certification) {
			return $this->certificationRepository->update($certification, ['is_active' => !$certification->is_active]);
		});
	}

	public function delete(Certification $certification): Certification
	{
		return DB::transaction(function () use ($certification) {
			return $this->certificationRepository->delete($certification);
		});
	}

	public function exportCertifications(?CertificationFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new CertificationExport($this->certificationRepository->query($dto)), 'certifications.xlsx');
	}
}
