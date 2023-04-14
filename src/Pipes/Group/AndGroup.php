<?php

namespace Ndinhbang\EloquentFilters\Pipes\Group;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Support\Arr;
use Ndinhbang\EloquentFilters\Concerns\HasChildren;
use Ndinhbang\EloquentFilters\Pipes\Base;

class AndGroup extends Base
{
    use HasChildren;

    protected function apply(BuilderContract $query, string|array|int|float|bool|null $value): BuilderContract
    {
        return $query->where(function (BuilderContract $qr) {
            return app(\Chefhasteeth\Pipeline\Pipeline::class)
                ->send($qr)
                ->through(
                    Arr::map(
                        $this->children,
                        fn(Base $pipe) => $pipe->prefix($this->prefix)
                    )
                )
                ->then(fn($passable) => $passable);
        });
    }
}
