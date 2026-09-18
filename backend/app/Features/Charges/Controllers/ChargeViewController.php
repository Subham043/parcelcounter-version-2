<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Charges\Resources\ChargeCollection;

class ChargeViewController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $charge = $this->chargeService->getById($id);
        return response()->json(["message" => "Charge fetched successfully.", "data" => ChargeCollection::make($charge)], 200);
    }
}
