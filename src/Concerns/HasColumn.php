<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasColumn
{
    protected array $columns = [];

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(string ...$columns): static
    {
        $this->columns = $columns;

        return $this;
    }
}
