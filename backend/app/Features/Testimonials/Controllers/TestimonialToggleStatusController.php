<?php

namespace App\Features\Testimonials\Controllers;

use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Testimonials\Resources\TestimonialCollection;

class TestimonialToggleStatusController extends Controller
{
    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Toggle the active status of an testimonial.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     *
     * This method retrieves the testimonial by the given ID, starts a database transaction,
     * and toggles the 'is_active' status of the testimonial. It returns a JSON response
     * indicating whether the testimonial was active or unactive successfully. In case
     * of an error, it returns a 400 status JSON response with an error message.
     */

    public function index($id)
    {
        $testimonial = $this->testimonialService->getById($id);
        try {
            //code...
            $updated_testimonial = $this->testimonialService->toggleActive($testimonial);
            if ($updated_testimonial->is_active) {
                return response()->json(["message" => "Testimonial is now active.", "data" => TestimonialCollection::make($updated_testimonial)], 200);
            }
            return response()->json(["message" => "Testimonial is now inactive.", "data" => TestimonialCollection::make($updated_testimonial)], 200);
        } catch (\Throwable $th) {
            return response()->json(["message" => "Something went wrong. Please try again"], 400);
        }
    }
}
