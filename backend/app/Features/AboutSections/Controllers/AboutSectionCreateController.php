<?php

namespace App\Features\AboutSections\Controllers;

use App\Features\AboutSections\DTO\AboutSectionDTO;
use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\AboutSections\Requests\AboutSectionCreatePostRequest;
use App\Features\AboutSections\Resources\AboutSectionCollection;

class AboutSectionCreateController extends Controller
{

    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(AboutSectionCreatePostRequest $request)
    {
        try {
            //code...
            $section = $this->sectionService->create(
                AboutSectionDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Section created successfully.",
                "data" => AboutSectionCollection::make($section),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
