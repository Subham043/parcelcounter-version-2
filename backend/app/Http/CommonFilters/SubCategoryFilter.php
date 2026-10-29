<?php

namespace App\Http\CommonFilters;

use Illuminate\Database\Eloquent\Builder;

class SubCategoryFilter
{
    public function __invoke(
        Builder $query,
        mixed $value
    ): void {
        $query->whereHas('sub_categories', function($q) use($value) {
            $q->where('sub_category_id', $value);
        });
    }
}