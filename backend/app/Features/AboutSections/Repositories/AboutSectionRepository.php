<?php

namespace App\Features\AboutSections\Repositories;


use App\Features\AboutSections\Models\AboutSection;
use App\Features\AboutSections\Interfaces\AboutSectionRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class AboutSectionRepository implements AboutSectionRepositoryInterface
{
    public function model(): Builder
    {
        return AboutSection::select('id', 'heading', 'description', 'description_unfiltered', 'image', 'is_active', 'user_id', 'created_at', 'updated_at');
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id', 'created_at')
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

    public function create(array $data): AboutSection
    {
        return $this->model()->create($data);
    }

    public function update(AboutSection $section, array $data): AboutSection
    {
        $section->update($data);
        return $section->refresh();
    }

    public function delete(AboutSection $section): AboutSection
    {
        $section->delete();
        return $section;
    }

    public function getById(int $id): AboutSection
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?AboutSection
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): AboutSection
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
            $q->where('heading', $value)
                ->orWhere('description_unfiltered', $value)
                ->orWhereRaw('MATCH(heading, description_unfiltered) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
