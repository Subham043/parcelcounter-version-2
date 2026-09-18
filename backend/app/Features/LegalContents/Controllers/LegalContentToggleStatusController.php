<?php

namespace App\Features\LegalContents\Controllers;

use App\Features\LegalContents\Interfaces\LegalContentServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\LegalContents\Resources\LegalContentCollection;

class LegalContentToggleStatusController extends Controller
{
    public function __construct(private LegalContentServiceInterface $legalContentService) {}

    /**
     * Toggle the active status of an legalContent.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the legalContent by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the legalContent. It returns a JSON response
     * indicating whether the legalContent was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $legalContent = $this->legalContentService->getById($id);
        try {
            //code...
            $updated_legalContent = $this->legalContentService->toggleActive($legalContent);
            if ($updated_legalContent->is_active) {
                return response()->json(["message" => "Legal Content is now active.", "data" => LegalContentCollection::make($updated_legalContent)], 200);
            }
            return response()->json(["message" => "Legal Content is now inactive.", "data" => LegalContentCollection::make($updated_legalContent)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
