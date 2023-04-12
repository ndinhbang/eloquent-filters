<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasOperator
{
    protected ?string $operator = null;

    public function operator(string $op = null): string|static
    {
        if (is_null($op)) {
            return $this->operator;
        }

        $this->operator = $op;

        return $this;
    }
}
