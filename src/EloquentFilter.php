<?php

namespace Ndinhbang\EloquentFilters;

use Chefhasteeth\Pipeline\Pipeline;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
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
     * @param BuilderContract $query
     * @return BuilderContract
     */
    public function apply(BuilderContract $query): BuilderContract
    {
        return app(Pipeline::class)
            ->send($query)
            ->through($this->getPipes())
            ->thenReturn();
    }
}
