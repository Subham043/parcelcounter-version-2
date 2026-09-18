<?php

namespace App\Features\Banners\Repositories;


use App\Features\Banners\Models\Banner;
use App\Features\Banners\Interfaces\BannerRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Spatie\QueryBuilder\QueryBuilder;
use Illuminate\Database\Eloquent\Builder;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\Filters\Filter;

class BannerRepository implements BannerRepositoryInterface
{
    public function model(): Builder
    {
        return Banner::select('id', 'title', 'alt', 'desktop_image', 'mobile_image', 'is_active', 'user_id', 'created_at', 'updated_at');
    }

    public function query(): QueryBuilder
    {
        return QueryBuilder::for($this->model())
            ->defaultSort('-id')
            ->allowedSorts('id')
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
            $q->where('title', $value)
                ->orWhere('alt', $value)
                ->orWhereRaw('MATCH(title, alt) AGAINST(? IN BOOLEAN MODE)', [$value . '*']);
        });
    }
}
