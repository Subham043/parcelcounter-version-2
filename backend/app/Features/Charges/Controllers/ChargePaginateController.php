<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Charges\Resources\ChargeCollection;
use Illuminate\Http\Request;

class ChargePaginateController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Returns a paginated collection of charges.
     *
     * @param Request $request
     * @return ChargeCollection
     */
    public function index(Request $request)
    {
        $data = $this->chargeService->paginate($request->total ?? 10);
        return ChargeCollection::collection($data);
    }
}
