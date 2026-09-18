<?php

namespace App\Features\ContactFormEnquiries\Controllers;

use App\Features\ContactFormEnquiries\DTO\ContactFormEnquiryDTO;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ContactFormEnquiries\Requests\ContactFormEnquiryPostRequest;
use App\Features\ContactFormEnquiries\Resources\ContactFormEnquiryCollection;

class ContactFormEnquiryCreateController extends Controller
{

    public function __construct(private ContactFormEnquiryServiceInterface $enquiryService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(ContactFormEnquiryPostRequest $request)
    {
        try {
            //code...
            $enquiry = $this->enquiryService->create(
                ContactFormEnquiryDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Enquiry created successfully.",
                "data" => ContactFormEnquiryCollection::make($enquiry),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
