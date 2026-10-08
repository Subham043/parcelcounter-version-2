<?php

namespace App\Features\Testimonials\Controllers;

use App\Features\Testimonials\DTO\TestimonialFilterDTO;
use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Features\Testimonials\Requests\TestimonialFilterRequest;
use App\Http\Controllers\Controller;
use App\Features\Testimonials\Resources\TestimonialCollection;

class TestimonialPaginateController extends Controller
{
    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Returns a paginated collection of testimonials.
     *
     * @param TestimonialFilterRequest $request
     * @return TestimonialCollection
     */
    public function index(TestimonialFilterRequest $request)
    {
        $data = $this->testimonialService->paginate(TestimonialFilterDTO::fromRequest($request));
        return TestimonialCollection::collection($data);
    }
}
