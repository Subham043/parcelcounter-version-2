<?php

namespace App\Features\BillingInformations\Repositories;

use App\Features\BillingInformations\DTO\BillingInformationFilterDTO;
use App\Features\BillingInformations\Models\BillingInformation;
use App\Features\BillingInformations\Interfaces\BillingInformationRepositoryInterface;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class BillingInformationRepository implements BillingInformationRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
        'name', 
        'created_at'
    ];

    private const SEARCH_COLUMNS = [
        'name',
        'email',
        'phone',
        'gst',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            'email', 
            'phone', 
            'gst', 
            'user_id',
            'updated_at'
        ];
    }

    public function model(int $user_id, ?BillingInformationFilterDTO $dto = null): Builder
    {
        return BillingInformation::select(...$this->getSelectColumns())->where('user_id', $user_id);
    }

    public function query(int $user_id, ?BillingInformationFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($user_id, $dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
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

    public function paginate(int $user_id, ?BillingInformationFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($user_id, $dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(int $user_id, ?BillingInformationFilterDTO $dto = null): Collection
    {
        return $this->query($user_id, $dto)->lazy(100)->collect();
    }
}
