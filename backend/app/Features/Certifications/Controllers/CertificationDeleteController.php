<?php

namespace App\Features\Certifications\Controllers;

use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Certifications\Resources\CertificationCollection;

class CertificationDeleteController extends Controller
{
    public function __construct(private CertificationServiceInterface $certificationService) {}

    /**
     * Delete a certification
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $certification = $this->certificationService->getById($id);
        try {
            //code...
            $this->certificationService->delete($certification);
            return response()->json(["message" => "Certification deleted successfully.", "data" => CertificationCollection::make($certification)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
