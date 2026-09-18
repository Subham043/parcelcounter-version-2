<?php

namespace App\Features\ContactFormEnquiries\Controllers;

use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ContactFormEnquiries\Resources\ContactFormEnquiryCollection;
use Illuminate\Http\Request;

class ContactFormEnquiryPaginateController extends Controller
{
    public function __construct(private ContactFormEnquiryServiceInterface $enquiryService) {}

    /**
     * Returns a paginated collection of enquiries.
     *
     * @param Request $request
     * @return ContactFormEnquiryCollection
     */
    public function index(Request $request)
    {
        $data = $this->enquiryService->paginate($request->total ?? 10);
        return ContactFormEnquiryCollection::collection($data);
    }
}
