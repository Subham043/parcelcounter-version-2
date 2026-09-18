<?php

namespace App\Features\AboutSections\Controllers;

use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\AboutSections\Resources\AboutSectionCollection;

class AboutSectionDeleteController extends Controller
{
    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Delete a section
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $section = $this->sectionService->getById($id);
        try {
            //code...
            $this->sectionService->delete($section);
            return response()->json(["message" => "Section deleted successfully.", "data" => AboutSectionCollection::make($section)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
