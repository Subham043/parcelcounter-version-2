<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\DTO\CategoryDTO;
use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Categories\Requests\CategoryUpdatePostRequest;
use App\Features\Categories\Resources\CategoryCollection;

class CategoryUpdateController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Update an category
     *
     * @param CategoryUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(CategoryUpdatePostRequest $request, $id)
    {
        $category = $this->categoryService->getById($id);
        try {
            //code...
            $updated_category = $this->categoryService->update(
                CategoryDTO::fromRequest($request),
                $category
            );
            return response()->json(["message" => "Category updated successfully.", "data" => CategoryCollection::make($updated_category)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
