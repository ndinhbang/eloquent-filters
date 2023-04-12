<?php

namespace Ndinhbang\EloquentFilters\Concerns;

trait HasMultiColumn
{
    protected array $columns = [];

    public function columns(?array $cols = null): array|static
    {
        if (is_null($cols)) {
            return $this->columns ?? [$this->paramKey];
        }

        $this->columns = $cols;

        return $this;
    }
}
