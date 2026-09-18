<?php

namespace App\Features\SubCategories\Controllers;

use App\Features\SubCategories\Interfaces\SubCategoryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\SubCategories\Resources\SubCategoryCollection;
use Illuminate\Http\Request;

class SubCategoryPaginateController extends Controller
{
    public function __construct(private SubCategoryServiceInterface $subCategoryService) {}

    /**
     * Returns a paginated collection of subCategories.
     *
     * @param Request $request
     * @return SubCategoryCollection
     */
    public function index(Request $request)
    {
        $data = $this->subCategoryService->paginate($request->total ?? 10, $request->query('include-category') == 'yes');
        return SubCategoryCollection::collection($data);
    }
}
