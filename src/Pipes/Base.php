<?php

namespace Ndinhbang\EloquentFilters\Pipes;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Http\Request;

abstract class Base
{
    protected Request $request;

    protected ?string $column = null;

    protected ?string $paramKey = null;

    protected ?string $valueAccessor = null;

    protected bool $positive = true;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    protected function shouldIgnore(string $paramKey): bool
    {
        return !$this->request->has($paramKey)
            || is_null($this->request->input($paramKey));
    }

    protected function value()
    {
        return $this->request->input($this->accessor());
    }

    public function accessor(?string $key = null): string|static
    {
        if (is_null($key)) {
            return $this->valueAccessor ?? $this->paramKey;
        }

        $this->valueAccessor = $key;

        return $this;
    }

    public function column(?string $key = null): string|static
    {
        if (is_null($key)) {
            return $this->column ?? $this->paramKey;
        }

        $this->column = $key;

        return $this;
    }

    public function handle(BuilderContract $query): BuilderContract
    {
        if ($this->shouldIgnore($this->paramKey)) {
            return $query;
        }
        return $this->apply($query);
    }

    public function negative(): static
    {
        $this->positive = false;
        return $this;
    }

    abstract protected function apply(BuilderContract $query): BuilderContract;

}
