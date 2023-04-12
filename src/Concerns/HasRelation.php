<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasRelation
{
    protected string $relation;

    /**
     * @param string $relation
     * @return $this
     */
    public function relation(string $relation): static
    {
        $this->relation = $relation;

        return $this;
    }

}
