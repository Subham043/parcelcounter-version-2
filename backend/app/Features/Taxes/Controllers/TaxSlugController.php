<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Resources\TaxCollection;

class TaxSlugController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Display the specified resource.
     *
     * @param  string  $slug
     * @return \Illuminate\Http\Response
     */
    public function index($slug)
    {
        $tax = $this->taxService->getBySlug($slug);
        return response()->json(["message" => "Tax fetched successfully.", "data" => TaxCollection::make($tax)], 200);
    }
}
