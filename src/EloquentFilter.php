<?php

namespace Ndinhbang\EloquentFilters;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;

abstract class EloquentFilter
{
    public function __construct(
        protected Request $request
    )
    {
        //
    }

    /**
     * @return array
     */
    abstract protected function getPipes(): array;

    /**
     * @param BuilderContract $query
     * @return BuilderContract
     */
    public function apply(BuilderContract $query): BuilderContract
    {
        return app(\Chefhasteeth\Pipeline\Pipeline::class)
            ->send($query)
            ->through($this->getPipes())
            ->then(fn($passable) => $passable);
    }
}
