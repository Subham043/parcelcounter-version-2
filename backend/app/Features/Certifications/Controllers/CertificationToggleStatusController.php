<?php

namespace App\Features\Certifications\Controllers;

use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Certifications\Resources\CertificationCollection;

class CertificationToggleStatusController extends Controller
{
    public function __construct(private CertificationServiceInterface $certificationService) {}

    /**
     * Toggle the active status of an certification.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the certification by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the certification. It returns a JSON response
     * indicating whether the certification was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $certification = $this->certificationService->getById($id);
        try {
            //code...
            $updated_certification = $this->certificationService->toggleActive($certification);
            if ($updated_certification->is_active) {
                return response()->json(["message" => "Certification is now active.", "data" => CertificationCollection::make($updated_certification)], 200);
            }
            return response()->json(["message" => "Certification is now inactive.", "data" => CertificationCollection::make($updated_certification)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
