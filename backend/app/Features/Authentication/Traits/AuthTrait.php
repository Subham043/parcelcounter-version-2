<?php

namespace App\Features\Authentication\Traits;

use App\Features\Roles\Enums\Roles;
use Illuminate\Database\Eloquent\Builder;

trait AuthTrait
{
    public function scopeIsActive(Builder $query): Builder
    {
        if(request()->user() && request()->user()->hasRole(Roles::SuperAdmin->value())) {
            return $query;
        }
        return $query->where('is_active', true);
    }
    public function scopeIsNotBlocked(Builder $query): Builder
    {
        if(request()->user() && request()->user()->hasRole(Roles::SuperAdmin->value())) {
            return $query;
        }
        return $query->where('is_blocked', false);
    }
}
