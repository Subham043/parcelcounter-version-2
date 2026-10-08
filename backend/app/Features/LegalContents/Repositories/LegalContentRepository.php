<?php

namespace App\Features\LegalContents\Repositories;

use App\Features\LegalContents\DTO\LegalContentFilterDTO;
use App\Features\LegalContents\Models\LegalContent;
use App\Features\LegalContents\Interfaces\LegalContentRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class LegalContentRepository implements LegalContentRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
    ];

    private const SEARCH_COLUMNS = [
        'name', 'slug', 'heading', 'description_unfiltered', 'meta_title', 'meta_description', 'meta_keywords'
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'heading', 
            'slug', 
            'description', 
            'description_unfiltered', 
            'meta_title', 
            'meta_description', 
            'meta_keywords', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }
    public function model(?LegalContentFilterDTO $dto = null): Builder
    {
        return LegalContent::select(...$this->getSelectColumns());
    }

    public function query(?LegalContentFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
            ]);
    }

    public function create(array $data): LegalContent
    {
        return $this->model()->create($data);
    }

    public function update(LegalContent $legalContent, array $data): LegalContent
    {
        $legalContent->update($data);
        return $legalContent->refresh();
    }

    public function delete(LegalContent $legalContent): LegalContent
    {
        $legalContent->delete();
        return $legalContent;
    }

    public function getById(int $id): LegalContent
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?LegalContent
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): LegalContent
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(?LegalContentFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?LegalContentFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
