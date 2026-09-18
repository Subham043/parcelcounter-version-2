<?php

namespace App\Features\ContactFormEnquiries\Interfaces;

use App\Features\ContactFormEnquiries\Models\ContactFormEnquiry;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;

interface ContactFormEnquiryRepositoryInterface
{
    public function model(): Builder;
    public function query(): QueryBuilder;
    public function create(array $data): ContactFormEnquiry;
    public function update(ContactFormEnquiry $enquiry, array $data): ContactFormEnquiry;
    public function delete(ContactFormEnquiry $enquiry): ContactFormEnquiry;
    public function getById(int $id): ContactFormEnquiry;
    public function getByColumn(string $column, mixed $value): ?ContactFormEnquiry;
    public function getByColumnOrFail(string $column, mixed $value): ContactFormEnquiry;
    public function paginate(int $total = 15): LengthAwarePaginator;
    public function getAll(): Collection;
}
