<?php

namespace App\Features\AboutSections\Controllers;

use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\AboutSections\Resources\AboutSectionCollection;
use Illuminate\Http\Request;

class AboutSectionPaginateController extends Controller
{
    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Returns a paginated collection of sections.
     *
     * @param Request $request
     * @return AboutSectionCollection
     */
    public function index(Request $request)
    {
        $data = $this->sectionService->paginate($request->total ?? 10);
        return AboutSectionCollection::collection($data);
    }
}
