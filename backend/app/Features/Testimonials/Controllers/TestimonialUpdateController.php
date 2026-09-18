<?php

namespace App\Features\Testimonials\Controllers;

use App\Features\Testimonials\DTO\TestimonialDTO;
use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Testimonials\Requests\TestimonialUpdatePostRequest;
use App\Features\Testimonials\Resources\TestimonialCollection;

class TestimonialUpdateController extends Controller
{
    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Update an testimonial
     *
     * @param TestimonialUpdatePostRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(TestimonialUpdatePostRequest $request, $id)
    {
        $testimonial = $this->testimonialService->getById($id);
        try {
            //code...
            $updated_testimonial = $this->testimonialService->update(
                TestimonialDTO::fromRequest($request),
                $testimonial
            );
            return response()->json(["message" => "Testimonial updated successfully.", "data" => TestimonialCollection::make($updated_testimonial)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
