<?php

namespace App\Features\ContactFormEnquiries\Controllers;

use App\Http\Controllers\Controller;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryServiceInterface;

class ContactFormEnquiryExportController extends Controller
{
    public function __construct(private ContactFormEnquiryServiceInterface $enquiryService) {}

    /**
     * Download all enquirys as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->enquiryService->exportContactFormEnquiries();
    }
}
