<?php

namespace App\Features\Banners\Repositories;

use App\Features\Banners\DTO\BannerFilterDTO;
use App\Features\Banners\Models\Banner;
use App\Features\Banners\Interfaces\BannerRepositoryInterface;
use App\Http\CommonFilters\BooleanFilter;
use App\Http\CommonFilters\SearchFilter;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;

class BannerRepository implements BannerRepositoryInterface
{
    private const SORT_COLUMNS = [
        'id',
    ];

    private const SEARCH_COLUMNS = [
        'title',
        'alt',
    ];

    private function getSelectColumns(): array
    {
        return [
            ...self::SORT_COLUMNS,
            ...self::SEARCH_COLUMNS,
            'desktop_image', 
            'mobile_image', 
            'is_active', 
            'user_id', 
            'created_at', 
            'updated_at'
        ];
    }

    public function model(?BannerFilterDTO $dto = null): Builder
    {
        return Banner::select($this->getSelectColumns());
    }

    public function query(?BannerFilterDTO $dto = null): QueryBuilder
    {
        return QueryBuilder::for($this->model($dto))
            ->defaultSort($dto?->sort ?? '-id')
            ->allowedSorts(...self::SORT_COLUMNS)
            ->allowedFilters([
                AllowedFilter::custom('search', new SearchFilter(self::SEARCH_COLUMNS), null, false),
                AllowedFilter::callback('is_active', new BooleanFilter),
            ]);
    }

    public function create(array $data): Banner
    {
        return $this->model()->create($data);
    }

    public function update(Banner $banner, array $data): Banner
    {
        $banner->update($data);
        return $banner->refresh();
    }

    public function delete(Banner $banner): Banner
    {
        $banner->delete();
        return $banner;
    }

    public function getById(int $id): Banner
    {
        return $this->model()->findOrFail($id);
    }

    public function getByColumn(string $column, mixed $value): ?Banner
    {
        return $this->model()->where($column, $value)->first();
    }

    public function getByColumnOrFail(string $column, mixed $value): Banner
    {
        return $this->model()->where($column, $value)->firstOrFail();
    }

    public function paginate(?BannerFilterDTO $dto = null): LengthAwarePaginator
    {
        return $this->query($dto)->paginate($dto?->total ?? 10)->appends(request()->query());
    }

    public function getAll(?BannerFilterDTO $dto = null): Collection
    {
        return $this->query($dto)->lazy(100)->collect();
    }
}
