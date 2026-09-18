<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Resources\SubCategoryCollection;
use Illuminate\Http\Request;

class SubCategorySlugController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug, Request $request)
    {
        $subCategory = $this->subCategoryService->getBySlug($slug, $request->query('include-category') == 'yes');
        return response()->json(["message" => "Sub Category fetched successfully.", "data" => SubCategoryCollection::make($subCategory)], 200);
    }
}
