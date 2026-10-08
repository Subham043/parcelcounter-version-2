<?php

namespace App\Features\Categories\Controllers;

use App\Features\Categories\DTO\CategoryFilterDTO;
use App\Features\Categories\Interfaces\CategoryServiceInterface;
use App\Features\Categories\Requests\CategoryFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Categories\Resources\CategoryCollection;

class CategoryPaginateController extends Controller
{
    public function __construct(private CategoryServiceInterface $categoryService) {}

    /**
     * Returns a paginated collection of categorys.
     *
     * @param CategoryFilterRequest $request
     * @return CategoryCollection
     */
    public function index(CategoryFilterRequest $request)
    {
        $data = $this->categoryService->paginate(CategoryFilterDTO::fromRequest($request));
        return CategoryCollection::collection($data);
    }
}
