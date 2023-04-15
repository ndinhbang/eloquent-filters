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
     * @param string|array|int|float|bool|null $value
     * @return bool
     */
    public function shouldSkip(string|array|int|float|bool|null $value): bool
    {
        return empty($value) || !is_array($value) || count($value) != 2 || $this->shouldIgnore($value);
    }

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
