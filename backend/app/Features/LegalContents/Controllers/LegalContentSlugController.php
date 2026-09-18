<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Resources\LegalContentCollection;

class LegalContentSlugController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Display the specified resource.
     *
     * @param  string $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $legalContent = $this->legalContentService->getBySlug($slug);
        return response()->json(["message" => "Legal Content fetched successfully.", "data" => LegalContentCollection::make($legalContent)], 200);
    }
}
