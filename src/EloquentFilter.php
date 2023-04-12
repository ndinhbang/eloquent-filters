<?php

namespace Ndinhbang\EloquentFilters;

use Chefhasteeth\Pipeline\Pipeline;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

abstract class EloquentFilter
{
    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    abstract protected function getPipes(): array;

    /**
     * @param Builder $query
     * @return Builder
     */
    public function apply(Builder $query): Builder
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($this->getPipes())
            ->thenReturn();
    }
}
