<?php

namespace App\Features\ContactFormEnquiries\Controllers;

use App\Features\ContactFormEnquiries\DTO\ContactFormEnquiryFilterDTO;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;
use App\Features\ContactFormEnquiries\Requests\ContactFormEnquiryFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\ContactFormEnquiries\Resources\ContactFormEnquiryCollection;
use Illuminate\Http\Request;

class ContactFormEnquiryPaginateController extends Controller
{
    public function __construct(private ContactFormEnquiryServiceInterface $enquiryService) {}

    /**
     * Returns a paginated collection of enquiries.
     *
     * @param ContactFormEnquiryFilterRequest $request
     * @return ContactFormEnquiryCollection
     */
    public function index(ContactFormEnquiryFilterRequest $request)
    {
        $data = $this->enquiryService->paginate(ContactFormEnquiryFilterDTO::fromRequest($request));
        return ContactFormEnquiryCollection::collection($data);
    }
}
