<?php

namespace App\Features\Testimonials\Services;

use App\Features\Testimonials\DTO\TestimonialDTO;
use App\Features\Testimonials\Exports\TestimonialExport;
use App\Features\Testimonials\Interfaces\TestimonialRepositoryInterface;
use App\Features\Testimonials\Interfaces\TestimonialServiceInterface;
use App\Features\Testimonials\Models\Testimonial;
use App\Http\Enums\Guards;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class TestimonialService implements TestimonialServiceInterface
{

	public function __construct(private TestimonialRepositoryInterface $testimonialRepository) {}

	public function paginate(Int $total = 10): LengthAwarePaginator
	{
		return $this->testimonialRepository->paginate($total);
	}

	public function getById(Int $id): Testimonial
	{
		return $this->testimonialRepository->getById($id);
	}

	public function create(TestimonialDTO $data): Testimonial
	{
		return DB::transaction(function () use ($data) {
			return $this->testimonialRepository->create([...$data->toArray(), 'user_id' => auth(Guards::API->value())->user()->id]);
		});
	}

	public function update(TestimonialDTO $data, Testimonial $testimonial): Testimonial
	{
		return DB::transaction(function () use ($data, $testimonial) {
			$image = $testimonial->image;
			if($data->image){
				$image = $data->image;
			}
			return $this->testimonialRepository->update($testimonial, [...$data->toArray(), 'image' => $image]);
		});
	}

	public function toggleActive(Testimonial $testimonial): Testimonial
	{
		return DB::transaction(function () use ($testimonial) {
			return $this->testimonialRepository->update($testimonial, ['is_active' => !$testimonial->is_active]);
		});
	}

	public function delete(Testimonial $testimonial): Testimonial
	{
		return DB::transaction(function () use ($testimonial) {
			return $this->testimonialRepository->delete($testimonial);
		});
	}

	public function exportTestimonials(): \Symfony\Component\HttpFoundation\BinaryFileResponse
	{
		return Excel::download(new TestimonialExport($this->testimonialRepository->query()), 'testimonials.xlsx');
	}
}
