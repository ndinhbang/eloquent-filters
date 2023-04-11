<?php

namespace Ndinhbang\EloquentFilters;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Ndinhbang\EloquentFilters\Skeleton\SkeletonClass
 */
class EloquentFiltersFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'eloquent-filters';
    }
}
