<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Resources\LegalContentCollection;

class LegalContentViewController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $legalContent = $this->legalContentService->getById($id);
        return response()->json(["message" => "Legal Content fetched successfully.", "data" => LegalContentCollection::make($legalContent)], 200);
    }
}
