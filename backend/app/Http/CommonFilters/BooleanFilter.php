<?php

namespace App\Http\CommonFilters;

use Illuminate\Database\Eloquent\Builder;

class BooleanFilter
{
    public function __invoke(
        Builder $query,
        mixed $value,
        string $property
    ): void {
        match (strtolower((string) $value)) {
            'yes' => $query->where($property, true),
            'no' => $query->where($property, false),
            default => null,
        };
    }
}