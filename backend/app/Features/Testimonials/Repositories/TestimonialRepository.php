<?php

namespace App\Features\Testimonials\Repositories;


use App\Features\Testimonials\Models\Testimonial;
use App\Features\Testimonials\Interfaces\TestimonialRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    public function model(): Builder
    {
        return Testimonial::select('id', 'name', 'designation', 'star', 'message', 'image', 'is_active', 'user_id', 'created_at', 'updated_at');
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id', 'name')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false),
                AllowedFilter::callback('is_active', function (Builder $query, $value) {
                    if (strtolower($value) == "yes") {
                        $query->where('is_active', true);
                    }
                    if (strtolower($value) == "no") {
                        $query->where('is_active', false);
                    }
                }),
            ]);
    }

    public function create(array $data): Testimonial
    {
        return $this->model()->create($data);
    }

    public function update(Testimonial $testimonial, array $data): Testimonial
    {
        $testimonial->update($data);
        return $testimonial->refresh();
    }

    public function delete(Testimonial $testimonial): Testimonial
    {
        $testimonial->delete();
        return $testimonial;
    }

    public function getById(int $id): Testimonial
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Testimonial
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Testimonial
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(int $total = 15): LengthAwarePaginator
    {
        return $this->query()->paginate($total)->appends(request()->query());
    }

    public function getAll(): Collection
    {
        return $this->query()->lazy(100)->collect();
    }
}

class CommonFilter implements Filter
{
    public function __invoke(Builder $query, mixed $value, string $property): void
    {
        $query->where(function ($q) use ($value) {
            $q->where('name', $value)
                ->orWhere('designation', $value)
                ->orWhere('message', $value)
                ->orWhereRaw('MATCH(name, designation, message) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
