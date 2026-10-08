<?php

namespace App\Features\AboutSections\Repositories;

use App\Features\AboutSections\DTO\AboutSectionFilterDTO;
use App\Features\AboutSections\Models\AboutSection;
use App\Features\AboutSections\Interfaces\AboutSectionRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class AboutSectionRepository implements AboutSectionRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id', 'created_at'
    ];

    private const SEARCH_COLUMNS = [
        'heading',
        'description_unfiltered',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS, ...self::SEARCH_COLUMNS, 'description', 'image', 'is_active', 'user_id', 'created_at', 'updated_at'
        ];
    }

    public function model(?AboutSectionFilterDTO $dto = null): Builder
    {
        return AboutSection::select(...$this->getSelectColumns());
    }

    public function query(?AboutSectionFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
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

    public function paginate(?AboutSectionFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?AboutSectionFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
