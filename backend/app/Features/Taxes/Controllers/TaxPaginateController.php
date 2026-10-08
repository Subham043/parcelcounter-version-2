<?php

namespace App\Features\Taxes\Controllers;

use App\Features\Taxes\DTO\TaxFilterDTO;
use App\Features\Taxes\Interfaces\TaxServiceInterface;
use App\Features\Taxes\Requests\TaxFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Taxes\Resources\TaxCollection;
use Illuminate\Http\Request;

class TaxPaginateController extends Controller
{
    public function __construct(private TaxServiceInterface $taxService) {}

    /**
     * Returns a paginated collection of taxs.
     *
     * @param TaxFilterRequest $request
     * @return TaxCollection
     */
    public function index(TaxFilterRequest $request)
    {
        $data = $this->taxService->paginate(TaxFilterDTO::fromRequest($request));
        return TaxCollection::collection($data);
    }
}
