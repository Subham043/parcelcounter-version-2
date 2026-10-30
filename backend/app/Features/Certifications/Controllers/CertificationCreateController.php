<?php

namespace App\Features\Certifications\Controllers;

use App\Features\Certifications\DTO\CertificationDTO;
use App\Features\Certifications\Interfaces\CertificationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Certifications\Requests\CertificationCreatePostRequest;
use App\Features\Certifications\Resources\CertificationCollection;

class CertificationCreateController extends Controller
{

    public function __construct(private CertificationServiceInterface $certificationService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(CertificationCreatePostRequest $request)
    {
        try {
            //code...
            $certification = $this->certificationService->create(
                CertificationDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Certification created successfully.",
                "data" => CertificationCollection::make($certification),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
