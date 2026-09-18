<?php

namespace App\Features\AboutSections\Controllers;

use App\Features\AboutSections\Interfaces\AboutSectionServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\AboutSections\Resources\AboutSectionCollection;

class AboutSectionViewController extends Controller
{
    public function __construct(private AboutSectionServiceInterface $sectionService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $section = $this->sectionService->getById($id);
        return response()->json(["message" => "Section fetched successfully.", "data" => AboutSectionCollection::make($section)], 200);
    }
}
