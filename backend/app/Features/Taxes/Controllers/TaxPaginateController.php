<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Resources\TaxCollection;
use Illuminate\Http\Request;

class TaxPaginateController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Returns a paginated collection of taxs.
     *
     * @param Request $request
     * @return TaxCollection
     */
    public function index(Request $request)
    {
        $data = $this->taxService->paginate($request->total ?? 10);
        return TaxCollection::collection($data);
    }
}
