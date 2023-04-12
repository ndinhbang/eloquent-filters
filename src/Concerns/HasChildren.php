<?php

namespace Ndinhbang\EloquentFilters\Concerns;

use Ndinhbang\EloquentFilters\Pipes\Base;

trait HasChildren
{
    protected array $children = [];

    /**
     * @param \Ndinhbang\EloquentFilters\Pipes\Base ...$pipes
     * @return $this
     */
    public function children(Base ...$pipes): static
    {
        $this->children = $pipes;

        return $this;
    }
}