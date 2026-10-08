<?php

namespace App\Features\BillingInformations\Controllers;

use App\Features\BillingInformations\DTO\BillingInformationFilterDTO;
use App\Features\BillingInformations\Interfaces\BillingInformationServiceInterface;
use App\Features\BillingInformations\Requests\BillingInformationFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\BillingInformations\Resources\BillingInformationCollection;
use Illuminate\Http\Request;

class BillingInformationPaginateController extends Controller
{
    public function __construct(private BillingInformationServiceInterface $informationService) {}

    /**
     * Returns a paginated collection of enquiries.
     *
     * @param BillingInformationFilterRequest $request
     * @return BillingInformationCollection
     */
    public function index(BillingInformationFilterRequest $request)
    {
        $data = $this->informationService->paginate(BillingInformationFilterDTO::fromRequest($request));
        return BillingInformationCollection::collection($data);
    }
}
