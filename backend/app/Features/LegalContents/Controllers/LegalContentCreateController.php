<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\DTO\LegalContentDTO;
use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Requests\LegalContentCreatePostRequest;
use App\Features\LegalContents\Resources\LegalContentCollection;

class LegalContentCreateController extends Controller
{

    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(LegalContentCreatePostRequest $request)
    {
        try {
            //code...
            $legalContent = $this->legalContentService->create(
                LegalContentDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Legal Content created successfully.",
                "data" => LegalContentCollection::make($legalContent),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
