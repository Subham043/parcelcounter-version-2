<?php

namespace App\Features\GlobalSearch\Controllers;

use App\Features\GlobalSearch\Interfaces\GlobalSearchServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\GlobalSearch\Resources\GlobalSearchCollection;
use Illuminate\Http\Request;

class GlobalSearchPaginateController extends Controller
{
    public function __construct(private GlobalSearchServiceInterface $searchService) {}

    /**
     * Returns a paginated collection of search.
     *
     * @param Request $request
     * @return GlobalSearchCollection
     */
    public function index(Request $request)
    {
        $search = $request->query('filter')['search'] ?? '';
        if(strlen($search) < 1) {
            return response()->json([
                'message' => 'Please provide a search term.',
            ], 422);
        }
        $data = $this->searchService->paginate($request->total ?? 10);
        return GlobalSearchCollection::collection($data);
    }
}
