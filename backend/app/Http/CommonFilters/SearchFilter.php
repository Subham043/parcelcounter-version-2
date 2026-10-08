<?php

namespace App\Http\CommonFilters;

use Spatie\QueryBuilder\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

class SearchFilter implements Filter
{
    public function __construct(
        private readonly array $searchColumns,
    ) {}

    public function __invoke(
        Builder $query,
        mixed $value,
        string $property
    ): void {
        $query->where(function (Builder $q) use ($value) {
            $q->where(function (Builder $q) use ($value) {
                foreach ($this->searchColumns as $column) {
                    $q->orWhere($column, $value);
                }
            });
            $search = preg_replace('/[+\-<>()~*"@]/', ' ', $value);
            $search = trim($search);

            if ($search !== '') {
                $q->orWhereRaw(
                    sprintf(
                    'MATCH(%s) AGAINST(? IN BOOLEAN MODE)',
                    implode(', ', $this->searchColumns)
                ),
                    [$search . '*']
                );
            }
        });
    }
}