<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\DTO\CategoryIdDTO;
use App\Features\SubCategories\DTO\SubCategoryDTO;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Requests\SubCategoryUpdatePostRequest;
use App\Features\SubCategories\Resources\SubCategoryCollection;

class SubCategoryUpdateController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Update an subCategory
     *
     * @param SubCategoryUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(SubCategoryUpdatePostRequest $request, $id)
    {
        $subCategory = $this->subCategoryService->getById($id);
        try {
            //code...
            $updated_sub_category = $this->subCategoryService->update(
                SubCategoryDTO::fromRequest($request),
                CategoryIdDTO::fromRequest($request),
                $subCategory
            );
            return response()->json(["message" => "Sub Category updated successfully.", "data" => SubCategoryCollection::make($updated_sub_category)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
