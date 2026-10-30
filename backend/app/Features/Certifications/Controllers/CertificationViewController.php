<?php

namespace App\Features\Certifications\Controllers;

use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Certifications\Resources\CertificationCollection;

class CertificationViewController extends Controller
{
    public function __construct(private CertificationServiceInterface $certificationService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $certification = $this->certificationService->getById($id);
        return response()->json(["message" => "Certification fetched successfully.", "data" => CertificationCollection::make($certification)], 200);
    }
}
