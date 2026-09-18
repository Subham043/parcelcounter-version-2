<?php

namespace App\Features\Testimonials\Controllers;

use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Testimonials\Resources\TestimonialCollection;

class TestimonialDeleteController extends Controller
{
    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Delete a testimonial
     *
     * @param int $id
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index($id)
    {
        $testimonial = $this->testimonialService->getById($id);
        try {
            //code...
            $this->testimonialService->delete($testimonial);
            return response()->json(["message" => "Testimonial deleted successfully.", "data" => TestimonialCollection::make($testimonial)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
