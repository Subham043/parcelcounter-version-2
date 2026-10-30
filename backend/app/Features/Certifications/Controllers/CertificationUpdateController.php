<?php

namespace App\Features\Certifications\Controllers;

use App\Features\Certifications\DTO\CertificationDTO;
use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Certifications\Requests\CertificationUpdatePostRequest;
use App\Features\Certifications\Resources\CertificationCollection;

class CertificationUpdateController extends Controller
{
    public function __construct(private CertificationServiceInterface $certificationService) {}

    /**
     * Update an certification
     *
     * @param CertificationUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CertificationUpdatePostRequest $request, $id)
    {
        $certification = $this->certificationService->getById($id);
        try {
            //code...
            $updated_certification = $this->certificationService->update(
                CertificationDTO::fromRequest($request),
                $certification
            );
            return response()->json(["message" => "Certification updated successfully.", "data" => CertificationCollection::make($updated_certification)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
