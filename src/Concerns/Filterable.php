<?php

namespace Ndinhbang\EloquentFilters\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Ndinhbang\EloquentFilters\EloquentFilter;

trait Filterable
{
    /**
     * @param BuilderContract $builder
     * @param EloquentFilter $filter
     * @return BuilderContract
     */
    public function scopeFilter(BuilderContract $builder, EloquentFilter $filter)
    {
        return $filter->apply($builder);
    }
}
