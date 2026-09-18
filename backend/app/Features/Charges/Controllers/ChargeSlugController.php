<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Charges\Resources\ChargeCollection;

class ChargeSlugController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $charge = $this->chargeService->getBySlug($slug);
        return response()->json(["message" => "Charge fetched successfully.", "data" => ChargeCollection::make($charge)], 200);
    }
}
