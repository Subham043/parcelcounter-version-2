<?php

namespace App\Features\Testimonials\Controllers;

use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Testimonials\Resources\TestimonialCollection;

class TestimonialViewController extends Controller
{
    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $testimonial = $this->testimonialService->getById($id);
        return response()->json(["message" => "Testimonial fetched successfully.", "data" => TestimonialCollection::make($testimonial)], 200);
    }
}
