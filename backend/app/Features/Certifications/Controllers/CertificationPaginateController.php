<?php

namespace App\Features\Certifications\Controllers;

use App\Features\Certifications\DTO\CertificationFilterDTO;
use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Features\Certifications\Requests\CertificationFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Certifications\Resources\CertificationCollection;

class CertificationPaginateController extends Controller
{
    public function __construct(private CertificationServiceInterface $certificationService) {}

    /**
     * Returns a paginated collection of certifications.
     *
     * @param CertificationFilterRequest $request
     * @return CertificationCollection
     */
    public function index(CertificationFilterRequest $request)
    {
        $data = $this->certificationService->paginate(CertificationFilterDTO::fromRequest($request));
        return CertificationCollection::collection($data);
    }
}
