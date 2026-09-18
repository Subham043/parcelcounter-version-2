<?php

namespace App\Features\AboutSections\Controllers;

use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\AboutSections\Resources\AboutSectionCollection;

class AboutSectionToggleStatusController extends Controller
{
    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Toggle the active status of an section.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the section by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the section. It returns a JSON response
     * indicating whether the section was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $section = $this->sectionService->getById($id);
        try {
            //code...
            $updated_section = $this->sectionService->toggleActive($section);
            if ($updated_section->is_active) {
                return response()->json(["message" => "Section is now active.", "data" => AboutSectionCollection::make($updated_section)], 200);
            }
            return response()->json(["message" => "Section is now inactive.", "data" => AboutSectionCollection::make($updated_section)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
