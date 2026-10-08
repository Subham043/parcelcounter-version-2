<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\DTO\LegalContentFilterDTO;
use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Features\LegalContents\Requests\LegalContentFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Resources\LegalContentCollection;

class LegalContentPaginateController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Returns a paginated collection of legalContents.
     *
     * @param LegalContentFilterRequest $request
     * @return LegalContentCollection
     */
    public function index(LegalContentFilterRequest $request)
    {
        $data = $this->legalContentService->paginate(LegalContentFilterDTO::fromRequest($request));
        return LegalContentCollection::collection($data);
    }
}
