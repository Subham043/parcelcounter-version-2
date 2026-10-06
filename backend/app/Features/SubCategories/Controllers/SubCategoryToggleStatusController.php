<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\DTO\SubCategoryFilterDTO;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Features\SubCategories\Requests\SubCategoryFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Resources\SubCategoryCollection;

class SubCategoryToggleStatusController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Toggle the active status of an subCategory.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the subCategory by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the subCategory. It returns a JSON response
     * indicating whether the subCategory was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id, SubCategoryFilterRequest $request)
    {
        $subCategory = $this->subCategoryService->getById($id, SubCategoryFilterDTO::fromRequest($request));
        try {
            //code...
            $updated_sub_category = $this->subCategoryService->toggleActive($subCategory);
            if ($updated_sub_category->is_active) {
                return response()->json(["message" => "Sub Category is now active.", "data" => SubCategoryCollection::make($updated_sub_category)], 200);
            }
            return response()->json(["message" => "Sub Category is now inactive.", "data" => SubCategoryCollection::make($updated_sub_category)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
