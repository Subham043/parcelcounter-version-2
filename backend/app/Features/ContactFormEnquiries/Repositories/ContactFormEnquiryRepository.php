<?php

namespace App\Features\ContactFormEnquiries\Repositories;


use App\Features\ContactFormEnquiries\Models\ContactFormEnquiry;
use App\Features\ContactFormEnquiries\Interfaces\ContactFormEnquiryRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class ContactFormEnquiryRepository implements ContactFormEnquiryRepositoryInterface
{
    public function model(): Builder
    {
        return ContactFormEnquiry::select('id', 'name', 'email', 'phone', 'subject', 'message', 'page_url', 'created_at', 'updated_at');
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id', 'name', 'created_at')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false)
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
                ->orWhere('email', $value)
                ->orWhere('phone', $value)
                ->orWhere('page_url', $value)
                ->orWhere('subject', $value)
                ->orWhere('message', $value)
                ->orWhereRaw('MATCH(name, email, phone, page_url, subject, message) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
