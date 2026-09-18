<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Categories\Resources\CategoryCollection;

class CategoryViewController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $category = $this->categoryService->getById($id);
        return response()->json(["message" => "Category fetched successfully.", "data" => CategoryCollection::make($category)], 200);
    }
}
