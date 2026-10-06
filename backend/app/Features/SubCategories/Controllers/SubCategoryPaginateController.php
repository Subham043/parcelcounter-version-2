<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\DTO\SubCategoryFilterDTO;
use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Features\SubCategories\Requests\SubCategoryFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Resources\SubCategoryCollection;

class SubCategoryPaginateController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Returns a paginated collection of subCategories.
     *
     * @param SubCategoryFilterRequest $request
     * @return SubCategoryCollection
     */
    public function index(SubCategoryFilterRequest $request)
    {
        $data = $this->subCategoryService->paginate(SubCategoryFilterDTO::fromRequest($request));
        return SubCategoryCollection::collection($data);
    }
}
