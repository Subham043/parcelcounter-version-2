<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\DTO\CategoryDTO;
use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Categories\Requests\CategoryCreatePostRequest;
use App\Features\Categories\Resources\CategoryCollection;

class CategoryCreateController extends Controller
{

    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(CategoryCreatePostRequest $request)
    {
        try {
            //code...
            $category = $this->categoryService->create(
                CategoryDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Category created successfully.",
                "data" => CategoryCollection::make($category),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
