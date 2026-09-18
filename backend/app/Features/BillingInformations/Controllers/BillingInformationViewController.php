<?php

namespace App\Features\BillingInformations\Controllers;

use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Resources\BillingInformationCollection;

class BillingInformationViewController extends Controller
{
    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $information = $this->informationService->getById($id);
        return response()->json(["message" => "Billing information fetched successfully.", "data" => BillingInformationCollection::make($information)], 200);
    }
}
