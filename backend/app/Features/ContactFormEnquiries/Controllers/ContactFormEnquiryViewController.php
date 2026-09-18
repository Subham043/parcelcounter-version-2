<?php

namespace App\Features\ContactFormEnquiries\Controllers;

use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ContactFormEnquiries\Resources\ContactFormEnquiryCollection;

class ContactFormEnquiryViewController extends Controller
{
    public function __construct(private ContactFormEnquiryServiceInterface $enquiryService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $enquiry = $this->enquiryService->getById($id);
        return response()->json(["message" => "Enquiry fetched successfully.", "data" => ContactFormEnquiryCollection::make($enquiry)], 200);
    }
}
