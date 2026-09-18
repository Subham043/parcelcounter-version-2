<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Categories\Resources\CategoryCollection;
use Illuminate\Http\Request;

class CategoryPaginateController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Returns a paginated collection of categorys.
     *
     * @param Request $request
     * @return CategoryCollection
     */
    public function index(Request $request)
    {
        $data = $this->categoryService->paginate($request->total ?? 10);
        return CategoryCollection::collection($data);
    }
}
