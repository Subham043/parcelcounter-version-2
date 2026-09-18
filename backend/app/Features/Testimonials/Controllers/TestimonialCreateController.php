<?php

namespace App\Features\Testimonials\Controllers;

use App\Features\Testimonials\DTO\TestimonialDTO;
use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Testimonials\Requests\TestimonialCreatePostRequest;
use App\Features\Testimonials\Resources\TestimonialCollection;

class TestimonialCreateController extends Controller
{

    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function index(TestimonialCreatePostRequest $request)
    {
        try {
            //code...
            $testimonial = $this->testimonialService->create(
                TestimonialDTO::fromRequest($request),
            );
            return response()->json([
                "message" => "Testimonial created successfully.",
                "data" => TestimonialCollection::make($testimonial),
            ], 201);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
