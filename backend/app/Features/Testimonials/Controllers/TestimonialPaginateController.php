<?php

namespace App\Features\Testimonials\Controllers;

use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Http\Controllers\Controller;
use App\Features\Testimonials\Resources\TestimonialCollection;
use Illuminate\Http\Request;

class TestimonialPaginateController extends Controller
{
    public function __construct(private TestimonialServiceInterface $testimonialService) {}

    /**
     * Returns a paginated collection of testimonials.
     *
     * @param Request $request
     * @return TestimonialCollection
     */
    public function index(Request $request)
    {
        $data = $this->testimonialService->paginate($request->total ?? 10);
        return TestimonialCollection::collection($data);
    }
}
