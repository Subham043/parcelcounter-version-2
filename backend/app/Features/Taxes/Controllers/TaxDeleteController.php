<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Resources\TaxCollection;

class TaxDeleteController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Delete a tax
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $tax = $this->taxService->getById($id);
        try {
            //code...
            $this->taxService->delete($tax);
            return response()->json(["message" => "Tax deleted successfully.", "data" => TaxCollection::make($tax)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
