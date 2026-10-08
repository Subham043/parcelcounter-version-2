<?php

namespace App\Features\AboutSections\Controllers;

use App\Features\AboutSections\DTO\AboutSectionFilterDTO;
use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Features\AboutSections\Requests\AboutSectionFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\AboutSections\Resources\AboutSectionCollection;
use Illuminate\Http\Request;

class AboutSectionPaginateController extends Controller
{
    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Returns a paginated collection of sections.
     *
     * @param AboutSectionFilterRequest $request
     * @return AboutSectionCollection
     */
    public function index(AboutSectionFilterRequest $request)
    {
        $data = $this->sectionService->paginate(AboutSectionFilterDTO::fromRequest($request));
        return AboutSectionCollection::collection($data);
    }
}
