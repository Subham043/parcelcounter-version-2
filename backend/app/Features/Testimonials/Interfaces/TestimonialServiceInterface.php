<?php

namespace App\Features\Testimonials\Interfaces;

use App\Features\Testimonials\DTO\TestimonialDTO;
use App\Features\Testimonials\Models\Testimonial;
use Illuminate\Pagination\LengthAwarePaginator;

interface TestimonialServiceInterface
{
    public function paginate(Int $total = 10): LengthAwarePaginator;
    public function create(TestimonialDTO $data): Testimonial;
    public function update(TestimonialDTO $data, Testimonial $testimonial): Testimonial;
    public function getById(int $id): Testimonial;
    public function delete(Testimonial $testimonial): Testimonial;
    public function toggleActive(Testimonial $testimonial): Testimonial;
    public function exportTestimonials(): \Symfony\Component\HttpFoundation\BinaryFileResponse;
}
