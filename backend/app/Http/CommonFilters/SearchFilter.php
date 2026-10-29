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
        if (empty($value) || !is_string($value)) {
            return;
        }

        $query->where(function (Builder $q) use ($value) {
            // 1. Fallback / Partial match using LIKE across columns
            $q->where(function (Builder $subQ) use ($value) {
                foreach ($this->searchColumns as $column) {
                    $subQ->orWhere($column, 'LIKE', "%{$value}%");
                }
            });

            // 2. Fulltext search optimization (if table is large)
            $search = preg_replace('/[+\-<>()~*"@]/', ' ', $value);
            $search = trim($search);

            if ($search !== '') {
                // Format words for boolean mode prefix matching (e.g., "foo bar" -> "+foo* +bar*")
                $words = array_filter(explode(' ', $search));
                $booleanSearch = implode(' ', array_map(fn($word) => '+' . $word . '*', $words));

                $q->orWhereRaw(
                    sprintf(
                        'MATCH(%s) AGAINST(? IN BOOLEAN MODE)',
                        implode(', ', $this->searchColumns)
                    ),
                    [$booleanSearch]
                );
            }
        });
    }
}