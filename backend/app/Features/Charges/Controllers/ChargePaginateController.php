<?php

namespace App\Features\Charges\Controllers;

use App\Features\Charges\DTO\ChargeFilterDTO;
use App\Features\Charges\Interfaces\ChargeServiceInterface;
use App\Features\Charges\Requests\ChargeFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Charges\Resources\ChargeCollection;

class ChargePaginateController extends Controller
{
    public function __construct(private ChargeServiceInterface $chargeService) {}

    /**
     * Returns a paginated collection of charges.
     *
     * @param ChargeFilterRequest $request
     * @return ChargeCollection
     */
    public function index(ChargeFilterRequest $request)
    {
        $data = $this->chargeService->paginate(ChargeFilterDTO::fromRequest($request));
        return ChargeCollection::collection($data);
    }
}
