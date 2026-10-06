<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\DTO\SubCategoryFilterDTO;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Features\SubCategories\Requests\SubCategoryFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Resources\SubCategoryCollection;

class SubCategoryViewController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id, SubCategoryFilterRequest $request)
    {
        $subCategory = $this->subCategoryService->getById($id, SubCategoryFilterDTO::fromRequest($request));
        return response()->json(["message" => "Sub Category fetched successfully.", "data" => SubCategoryCollection::make($subCategory)], 200);
    }
}
