<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\DTO\CategoryIdDTO;
use App\Features\SubCategories\DTO\SubCategoryDTO;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Requests\SubCategoryCreatePostRequest;
use App\Features\SubCategories\Resources\SubCategoryCollection;

class SubCategoryCreateController extends Controller
{

    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(SubCategoryCreatePostRequest $request)
    {
        try {
            //code...
            $subCategory = $this->subCategoryService->create(
                SubCategoryDTO::fromRequest($request),
                CategoryIdDTO::fromRequest($request)
            );
            return response()->json([
                "message" => "Sub Category created successfully.",
                "data" => SubCategoryCollection::make($subCategory),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
