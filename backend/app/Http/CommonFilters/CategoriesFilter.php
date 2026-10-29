<?php

namespace App\Http\CommonFilters;

use Illuminate\Database\Eloquent\Builder;

class CategoriesFilter
{
    public function __invoke(
        Builder $query,
        mixed $value
    ): void {
        $query->whereHas('categories', function($q) use($value) {
            $q->whereIn('category_id', explode(',', $value));
        });
    }
}