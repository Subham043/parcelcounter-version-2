<?php

namespace App\Features\Testimonials\Interfaces;

use App\Features\Testimonials\DTO\TestimonialFilterDTO;
use App\Features\Testimonials\Models\Testimonial;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface TestimonialRepositoryInterface
{
    public function model(?TestimonialFilterDTO $dto = null): Builder;
    public function query(?TestimonialFilterDTO $dto = null): QueryBuilder;
    public function create(array $data): Testimonial;
    public function update(Testimonial $testimonial, array $data): Testimonial;
    public function delete(Testimonial $testimonial): Testimonial;
    public function getById(int $id): Testimonial;
    public function getByColumn(string $column, mixed $value): ?Testimonial;
    public function getByColumnOrFail(string $column, mixed $value): Testimonial;
    public function paginate(?TestimonialFilterDTO $dto = null): LengthAwarePaginator;
    public function getAll(?TestimonialFilterDTO $dto = null): Collection;
}
