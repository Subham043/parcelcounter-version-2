<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Categories\Resources\CategoryCollection;

class CategoryDeleteController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Delete a category
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $category = $this->categoryService->getById($id);
        try {
            //code...
            $this->categoryService->delete($category);
            return response()->json(["message" => "Category deleted successfully.", "data" => CategoryCollection::make($category)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
