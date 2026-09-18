<?php

namespace App\Features\Roles\Interfaces;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;

interface RoleTraitInterface
{
	public function scopeHasRoles(Builder $query, array $roles): Builder;
	public function scopeDoesNotHaveRoles(Builder $query, array $roles): Builder;
}
