<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Categories\Resources\CategoryCollection;

class CategorySlugController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $category = $this->categoryService->getBySlug($slug);
        return response()->json(["message" => "Category fetched successfully.", "data" => CategoryCollection::make($category)], 200);
    }
}
