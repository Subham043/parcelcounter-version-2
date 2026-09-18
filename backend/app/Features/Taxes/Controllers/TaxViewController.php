<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Resources\TaxCollection;

class TaxViewController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $tax = $this->taxService->getById($id);
        return response()->json(["message" => "Tax fetched successfully.", "data" => TaxCollection::make($tax)], 200);
    }
}
