<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Resources\LegalContentCollection;
use Illuminate\Http\Request;

class LegalContentPaginateController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Returns a paginated collection of legalContents.
     *
     * @param Request $request
     * @return LegalContentCollection
     */
    public function index(Request $request)
    {
        $data = $this->legalContentService->paginate($request->total ?? 10);
        return LegalContentCollection::collection($data);
    }
}
