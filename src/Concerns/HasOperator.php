<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasOperator
{
    protected ?string $operator = null;

    /**
     * @param string $operator
     * @return $this
     */
    public function operator(string $operator): static
    {
        $this->operator = $operator;

        return $this;
    }
}
