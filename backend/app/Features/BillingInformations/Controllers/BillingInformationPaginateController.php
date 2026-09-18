<?php

namespace App\Features\BillingInformations\Controllers;

use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Resources\BillingInformationCollection;
use Illuminate\Http\Request;

class BillingInformationPaginateController extends Controller
{
    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Returns a paginated collection of enquiries.
     *
     * @param Request $request
     * @return BillingInformationCollection
     */
    public function index(Request $request)
    {
        $data = $this->informationService->paginate($request->total ?? 10);
        return BillingInformationCollection::collection($data);
    }
}
