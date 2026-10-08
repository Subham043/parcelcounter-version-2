<?php

namespace App\Features\ContactFormEnquiries\Repositories;

use App\Features\ContactFormEnquiries\DTO\ContactFormEnquiryFilterDTO;
use App\Features\ContactFormEnquiries\Models\ContactFormEnquiry;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryRepositoryInterface;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class ContactFormEnquiryRepository implements ContactFormEnquiryRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name',
        'created_at'
    ];

    private const SEARCH_COLUMNS = [
        'name', 'email', 'phone', 'page_url', 'subject', 'message'
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'name', 
            'email', 
            'phone', 
            'subject', 
            'message', 
            'page_url',
            'updated_at'
        ];
    }

    public function model(?ContactFormEnquiryFilterDTO $dto = null): Builder
    {
        return ContactFormEnquiry::select(...$this->getSelectColumns());
    }

    public function query(?ContactFormEnquiryFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false)
            ]);
    }

    public function create(array $data): ContactFormEnquiry
    {
        return $this->model()->create($data);
    }

    public function update(ContactFormEnquiry $enquiry, array $data): ContactFormEnquiry
    {
        $enquiry->update($data);
        return $enquiry->refresh();
    }

    public function delete(ContactFormEnquiry $enquiry): ContactFormEnquiry
    {
        $enquiry->delete();
        return $enquiry;
    }

    public function getById(int $id): ContactFormEnquiry
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?ContactFormEnquiry
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): ContactFormEnquiry
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(?ContactFormEnquiryFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?ContactFormEnquiryFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}