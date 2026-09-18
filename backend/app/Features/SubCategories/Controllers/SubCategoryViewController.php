<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Resources\SubCategoryCollection;
use Illuminate\Http\Request;

class SubCategoryViewController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id, Request $request)
    {
        $subCategory = $this->subCategoryService->getById($id, $request->query('include-category') == 'yes');
        return response()->json(["message" => "Sub Category fetched successfully.", "data" => SubCategoryCollection::make($subCategory)], 200);
    }
}
