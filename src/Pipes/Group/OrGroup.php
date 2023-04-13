<?php

namespace Ndinhbang\EloquentFilters\Pipes\Group;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Support\Arr;
use Ndinhbang\EloquentFilters\Concerns\HasChildren;
use Ndinhbang\EloquentFilters\Contracts\Pipe;
use Ndinhbang\EloquentFilters\Pipes\Base;

class OrGroup extends Base
{
    use HasChildren;

    protected function apply(BuilderContract $query): BuilderContract
    {
        return $query->orWhere( function (BuilderContract $qr) {
            return app(\Chefhasteeth\Pipeline\Pipeline::class)
                ->send($qr)
                ->through(
                    Arr::map(
                        $this->children,
                        fn (Pipe $pipe) => $pipe->prefix($this->prefix)
                    )
                )
                ->then(fn($passable) => $passable);
        });
    }
}
