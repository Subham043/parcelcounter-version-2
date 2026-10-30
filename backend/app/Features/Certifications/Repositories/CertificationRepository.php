<?php

namespace App\Features\Certifications\Repositories;

use App\Features\Certifications\DTO\CertificationFilterDTO;
use App\Features\Certifications\Models\Certification;
use App\Features\Certifications\Interfaces\CertificationRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class CertificationRepository implements CertificationRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
    ];

    private const SEARCH_COLUMNS = [
        'title',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            ...self::SEARCH_COLUMNS,
            'image', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }

    public function model(?CertificationFilterDTO $dto = null): Builder
    {
        return Certification::select($this->getSelectColumns());
    }

    public function query(?CertificationFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::callback('is_active', new BooleanFilter),
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
            ]);
    }

    public function create(array $data): Certification
    {
        return $this->model()->create($data);
    }

    public function update(Certification $certification, array $data): Certification
    {
        $certification->update($data);
        return $certification->refresh();
    }

    public function delete(Certification $certification): Certification
    {
        $certification->delete();
        return $certification;
    }

    public function getById(int $id): Certification
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Certification
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Certification
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(?CertificationFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?CertificationFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
