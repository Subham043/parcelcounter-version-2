<?php

namespace App\Features\Testimonials\Interfaces;

use App\Features\Testimonials\Models\Testimonial;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface TestimonialRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): Testimonial;
    public function update(Testimonial $testimonial, array $data): Testimonial;
    public function delete(Testimonial $testimonial): Testimonial;
    public function getById(int $id): Testimonial;
    public function getByColumn(string $column, mixed $value): ?Testimonial;
    public function getByColumnOrFail(string $column, mixed $value): Testimonial;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
