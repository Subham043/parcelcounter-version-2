<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Resources\SubCategoryCollection;

class SubCategoryDeleteController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Delete a subCategory
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $subCategory = $this->subCategoryService->getById($id);
        try {
            //code...
            $this->subCategoryService->delete($subCategory);
            return response()->json(["message" => "Sub Category deleted successfully.", "data" => SubCategoryCollection::make($subCategory)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
