<?php

namespace Ndinhbang\EloquentFilters\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Ndinhbang\EloquentFilters\EloquentFilter;

trait Filterable
{
    /**
     * @param Builder $builder
     * @param EloquentFilter $filter
     * @return Builder
     */
    public function scopeFilter(Builder $builder, EloquentFilter $filter)
    {
        return $filter->apply($builder);
    }
}
