<?php

namespace App\Features\BillingInformations\Repositories;


use App\Features\BillingInformations\Models\BillingInformation;
use App\Features\BillingInformations\Interfaces\BillingInformationRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class BillingInformationRepository implements BillingInformationRepositoryInterface
{
    public function model(int $user_id): Builder
    {
        return BillingInformation::select('id', 'name', 'email', 'phone', 'gst', 'user_id', 'created_at', 'updated_at')->where('user_id', $user_id);
    }

    public function query(int $user_id): QueryBuilder
    {
        return QueryBuilder::for($this->model($user_id))
            ->defaultSort('-id')
            ->allowedSorts('id', 'name', 'created_at')
            ->allowedFilters([
                AllowedFilter::custom('search', new CommonFilter, null, false)
            ]);
    }

    public function create(int $user_id, array $data): BillingInformation
    {
        return $this->model($user_id)->create([...$data, 'user_id'=>$user_id]);
    }

    public function update(BillingInformation $enquiry, array $data): BillingInformation
    {
        $enquiry->update($data);
        return $enquiry->refresh();
    }

    public function delete(BillingInformation $enquiry): BillingInformation
    {
        $enquiry->delete();
        return $enquiry;
    }

    public function getById(int $user_id, int $id): BillingInformation
    {
        return $this->model($user_id)->findOrFail($id);
    }

    public function getByColumn(int $user_id, string $column, mixed $value): ?BillingInformation
    {
        return $this->model($user_id)->where($column, $value)->first();
    }

    public function getByColumnOrFail(int $user_id, string $column, mixed $value): BillingInformation
    {
        return $this->model($user_id)->where($column, $value)->firstOrFail();
    }

    public function paginate(int $user_id, int $total = 15): LengthAwarePaginator
    {
        return $this->query($user_id)->paginate($total)->appends(request()->query());
    }

    public function getAll(int $user_id): Collection
    {
        return $this->query($user_id)->lazy(100)->collect();
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
                ->orWhere('gst', $value)
                ->orWhereRaw('MATCH(name, email, phone, gst) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
