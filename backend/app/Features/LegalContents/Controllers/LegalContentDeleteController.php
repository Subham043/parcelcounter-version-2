<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Resources\LegalContentCollection;

class LegalContentDeleteController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Delete a legalContent
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $legalContent = $this->legalContentService->getById($id);
        try {
            //code...
            $this->legalContentService->delete($legalContent);
            return response()->json(["message" => "Legal Content deleted successfully.", "data" => LegalContentCollection::make($legalContent)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
