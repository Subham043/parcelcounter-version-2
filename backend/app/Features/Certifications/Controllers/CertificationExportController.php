<?php

namespace App\Features\Certifications\Controllers;

use App\Features\Certifications\DTO\CertificationFilterDTO;
use App\Http\Controllers\Controller;
use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Features\Certifications\Requests\CertificationFilterRequest;

class CertificationExportController extends Controller
{
    public function __construct(private CertificationServiceInterface $certificationService) {}

    /**
     * Download all certifications as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index(CertificationFilterRequest $request)
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->certificationService->exportCertifications(CertificationFilterDTO::fromRequest($request));
    }
}
