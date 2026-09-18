<?php

namespace App\Features\ContactFormEnquiries\Controllers;

use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\ContactFormEnquiries\Resources\ContactFormEnquiryCollection;

class ContactFormEnquiryDeleteController extends Controller
{
    public function __construct(private ContactFormEnquiryServiceInterface $enquiryService) {}

    /**
     * Delete a enquiry
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $enquiry = $this->enquiryService->getById($id);
        try {
            //code...
            $this->enquiryService->delete($enquiry);
            return response()->json(["message" => "Enquiry deleted successfully.", "data" => ContactFormEnquiryCollection::make($enquiry)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
