<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasOperator
{
    protected ?string $operator = null;

    /**
     * @return string|null
     */
    public function operator(): ?string
    {
        return $this->operator;
    }

    /**
     * @param string $operator
     * @return $this
     */
    public function setOperator(string $operator): static
    {
        $this->operator = $operator;

        return $this;
    }
}
