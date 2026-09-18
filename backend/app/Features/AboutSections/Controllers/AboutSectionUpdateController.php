<?php

namespace App\Features\AboutSections\Controllers;

use App\Features\AboutSections\DTO\AboutSectionDTO;
use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\AboutSections\Requests\AboutSectionUpdatePostRequest;
use App\Features\AboutSections\Resources\AboutSectionCollection;

class AboutSectionUpdateController extends Controller
{
    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Update an section
     *
     * @param AboutSectionUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AboutSectionUpdatePostRequest $request, $id)
    {
        $section = $this->sectionService->getById($id);
        try {
            //code...
            $updated_section = $this->sectionService->update(
                AboutSectionDTO::fromRequest($request),
                $section
            );
            return response()->json(["message" => "Section updated successfully.", "data" => AboutSectionCollection::make($updated_section)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
