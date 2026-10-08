<?php

namespace App\Http\CommonFilters;

use Illuminate\Database\Eloquent\Builder;

class CategoryFilter
{
    public function __invoke(
        Builder $query,
        mixed $value
    ): void {
        $query->whereHas('categories', function($q) use($value) {
            $q->where('category_id', $value);
        });
    }
}