<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasRange
{
    /**
     * when true, use >= instead of >
     * @var bool
     */
    protected bool $includeStart = true;

    /**
     * when true, use <= instead of <
     * @var bool
     */
    protected bool $includeEnd = true;

    /**
     * @return $this
     */
    public function dontIncludeStart(): static
    {
        $this->includeStart = false;

        return $this;
    }

    /**
     * @return $this
     */
    public function dontIncludeEnd(): static
    {
        $this->includeEnd = false;

        return $this;
    }

    public function dontIncludeBoth(): static
    {
        $this->includeStart = false;
        $this->includeEnd = false;

        return $this;
    }
}
