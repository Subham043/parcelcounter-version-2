<?php

namespace App\Features\Testimonials\Controllers;

use App\Http\Controllers\Controller;
use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;

class TestimonialExportController extends Controller
{
    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Download all testimonials as excel file
     *
     * @return \Symfony\Component\HttpFoundation\BinaryFileResponse
     */
    public function index()
    {
        ini_set('memory_limit', '-1');
        ini_set('max_execution_time', 300);
        return $this->testimonialService->exportTestimonials();
    }
}
