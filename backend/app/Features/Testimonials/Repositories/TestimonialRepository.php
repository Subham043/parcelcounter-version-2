<?php

namespace App\Features\Testimonials\Repositories;

use App\Features\Testimonials\DTO\TestimonialFilterDTO;
use App\Features\Testimonials\Models\Testimonial;
use App\Features\Testimonials\Interfaces\TestimonialRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class TestimonialRepository implements TestimonialRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'designation',
        'message',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'designation', 'star', 'message', 'image', 'is_active', 'user_id', 'created_at', 'updated_at'
        ];
    }

    public function model(?TestimonialFilterDTO $dto = null): Builder
    {
        return Testimonial::select(...$this->getSelectColumns());
    }

    public function query(?TestimonialFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
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

    public function paginate(?TestimonialFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?TestimonialFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}