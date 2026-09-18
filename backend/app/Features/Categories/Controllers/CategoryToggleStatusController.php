<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Categories\Resources\CategoryCollection;

class CategoryToggleStatusController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Toggle the active status of an category.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the category by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the category. It returns a JSON response
     * indicating whether the category was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $category = $this->categoryService->getById($id);
        try {
            //code...
            $updated_category = $this->categoryService->toggleActive($category);
            if ($updated_category->is_active) {
                return response()->json(["message" => "Category is now active.", "data" => CategoryCollection::make($updated_category)], 200);
            }
            return response()->json(["message" => "Category is now inactive.", "data" => CategoryCollection::make($updated_category)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
