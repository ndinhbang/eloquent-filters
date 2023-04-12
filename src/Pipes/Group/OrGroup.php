<?php

namespace Ndinhbang\EloquentFilters\Pipes\Group;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Ndinhbang\EloquentFilters\Contracts\Pipe;
use Ndinhbang\EloquentFilters\Pipes\Base;

class OrGroup extends Base
{
    /**
     * @param Request $request
     * @param string|null $key
     * @param string|null $prefix
     * @param array $children
     */
    public function __construct(
        protected Request $request,
        protected ?string $key,
        protected ?string $prefix = null,
        protected array   $children = [],
    )
    {
        parent::__construct($request, $key, $prefix);
    }

    /**
     * @return bool
     */
    protected function shouldSkip(): bool
    {
        if (!$this->request->has($this->accessor()) || empty($this->value())) {
            return true;
        }

        return false;
    }

    protected function apply(BuilderContract $query): BuilderContract
    {
        return $query->orWhere( function (BuilderContract $qr) {
            return app(\Chefhasteeth\Pipeline\Pipeline::class)
                ->send($qr)
                ->through(
                    Arr::map(
                        $this->children,
                        fn (Pipe $pipe) => $pipe->setPrefix($this->prefix)
                    )
                )
                ->then(fn($passable) => $passable);
        });
    }
}
