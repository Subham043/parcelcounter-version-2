<?php

namespace App\Features\Certifications\Interfaces;

use App\Features\Certifications\DTO\CertificationDTO;
use App\Features\Certifications\DTO\CertificationFilterDTO;
use App\Features\Certifications\Models\Certification;
use Illuminate\Pagination\LengthAwarePaginator;

interface CertificationServiceInterface
{
    public function paginate(?CertificationFilterDTO $dto = null): LengthAwarePaginator;
    public function create(CertificationDTO $data): Certification;
    public function update(CertificationDTO $data, Certification $certification): Certification;
    public function getById(int $id): Certification;
    public function delete(Certification $certification): Certification;
    public function toggleActive(Certification $certification): Certification;
    public function exportCertifications(?CertificationFilterDTO $dto = null): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
