<?php

namespace App\Features\GlobalSearch\Controllers;

use App\Features\GlobalSearch\DTO\GlobalSearchFilterDTO;
use App\Features\GlobalSearch\Interfaces\GlobalSearchServiceInterface;
use App\Features\GlobalSearch\Requests\GlobalSearchFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\GlobalSearch\Resources\GlobalSearchCollection;

class GlobalSearchPaginateController extends Controller
{
    public function __construct(private GlobalSearchServiceInterface $searchService) {}

    /**
     * Returns a paginated collection of search.
     *
     * @param GlobalSearchFilterRequest $request
     * @return GlobalSearchCollection
     */
    public function index(GlobalSearchFilterRequest $request)
    {
        $dto = GlobalSearchFilterDTO::fromRequest($request);
        $search = $dto?->search ?? '';
        if(strlen($search) < 1) {
            return response()->json([
                'message' => 'Please provide a search term.',
            ], 422);
        }
        $data = $this->searchService->paginate($dto);
        return GlobalSearchCollection::collection($data);
    }
}
