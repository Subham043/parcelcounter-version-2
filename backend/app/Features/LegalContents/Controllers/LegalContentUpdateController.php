<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\DTO\LegalContentDTO;
use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Requests\LegalContentUpdatePostRequest;
use App\Features\LegalContents\Resources\LegalContentCollection;

class LegalContentUpdateController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Update an legalContent
     *
     * @param LegalContentUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(LegalContentUpdatePostRequest $request, $id)
    {
        $legalContent = $this->legalContentService->getById($id);
        try {
            //code...
            $updated_legalContent = $this->legalContentService->update(
                LegalContentDTO::fromRequest($request),
                $legalContent
            );
            return response()->json(["message" => "Legal Content updated successfully.", "data" => LegalContentCollection::make($updated_legalContent)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
